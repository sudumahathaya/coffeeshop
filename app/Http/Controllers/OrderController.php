<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\MenuItem;
use App\Models\LoyaltyPoint;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:menu_items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'nullable|email',
            'customer_phone' => 'nullable|string|max:20',
            'order_type' => 'required|in:dine_in,takeaway,delivery',
            'special_instructions' => 'nullable|string|max:1000',
            'payment_method' => 'required|in:cash,card,online,mobile',
            'payment_token' => 'nullable|string', // For online payments
        ]);

        DB::beginTransaction();
        
        try {
            // Calculate order totals
            $subtotal = 0;
            $orderItems = [];

            foreach ($validatedData['items'] as $item) {
                $menuItem = MenuItem::find($item['id']);
                $itemTotal = $menuItem->price * $item['quantity'];
                $subtotal += $itemTotal;

                $orderItems[] = [
                    'id' => $menuItem->id,
                    'name' => $menuItem->name,
                    'price' => $menuItem->price,
                    'quantity' => $item['quantity'],
                    'total' => $itemTotal
                ];
            }

            $tax = $subtotal * 0.1; // 10% tax
            $total = $subtotal + $tax;

            // Generate order ID
            $orderId = 'ORD' . str_pad(Order::count() + 1, 6, '0', STR_PAD_LEFT);

            // Process payment if online
            $paymentStatus = 'pending';
            $transactionId = null;
            
            if ($validatedData['payment_method'] === 'online' && $validatedData['payment_token']) {
                $paymentService = new PaymentService();
                $paymentResult = $paymentService->processPayment($validatedData['payment_token'], $total);
                
                if ($paymentResult['success']) {
                    $paymentStatus = 'completed';
                    $transactionId = $paymentResult['transaction_id'];
                } else {
                    throw new \Exception('Payment failed: ' . $paymentResult['message']);
                }
            } elseif ($validatedData['payment_method'] === 'mobile') {
                // Mobile payment processing
                $paymentStatus = 'completed';
                $transactionId = 'MOB' . time() . rand(1000, 9999);
            } elseif ($validatedData['payment_method'] === 'cash') {
                $paymentStatus = 'pending';
            } else {
                $paymentStatus = 'pending';
            }

            // Create order
            $order = Order::create([
                'order_id' => $orderId,
                'user_id' => Auth::id(),
                'customer_name' => $validatedData['customer_name'],
                'customer_email' => $validatedData['customer_email'],
                'customer_phone' => $validatedData['customer_phone'],
                'items' => $orderItems,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
                'order_type' => $validatedData['order_type'],
                'special_instructions' => $validatedData['special_instructions'],
                'payment_method' => $validatedData['payment_method'],
                'payment_status' => $paymentStatus,
                'transaction_id' => $transactionId,
                'status' => 'confirmed'
            ]);

            // Award loyalty points (1 point per Rs. 10 spent)
            if (Auth::check()) {
                $pointsEarned = floor($total / 10);
                
                LoyaltyPoint::create([
                    'user_id' => Auth::id(),
                    'points' => $pointsEarned,
                    'type' => 'earned',
                    'description' => "Points earned from order #{$orderId}",
                    'order_id' => $order->id
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully!',
                'order_id' => $orderId,
                'order' => $order,
                'payment_status' => $paymentStatus
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to place order: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($orderId)
    {
        $order = Order::where('order_id', $orderId)->firstOrFail();
        
        // Check if user owns this order or is admin
        if (Auth::check() && (Auth::id() === $order->user_id || Auth::user()->isAdmin())) {
            return response()->json([
                'success' => true,
                'order' => $order
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Order not found or access denied'
        ], 404);
    }

    public function updateStatus(Request $request, $orderId)
    {
        $validatedData = $request->validate([
            'status' => 'required|in:pending,confirmed,preparing,ready,completed,cancelled'
        ]);

        $order = Order::where('order_id', $orderId)->firstOrFail();
        $oldStatus = $order->status;
        $order->update(['status' => $validatedData['status']]);

        if ($validatedData['status'] === 'completed') {
            $order->update(['completed_at' => now()]);
        }

        // Broadcast real-time update
        broadcast(new \App\Events\OrderUpdated($order))->toOthers();

        return response()->json([
            'success' => true,
            'message' => 'Order status updated successfully',
            'order' => $order,
            'old_status' => $oldStatus,
            'new_status' => $validatedData['status']
        ]);
    }

    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(20);
        return response()->json([
            'success' => true,
            'orders' => $orders
        ]);
    }

    public function getUserOrders()
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Authentication required'
            ], 401);
        }

        $orders = Auth::user()->orders()->latest()->get();
        return response()->json([
            'success' => true,
            'orders' => $orders
        ]);
    }

    public function destroy($orderId)
    {
        try {
            $order = Order::where('order_id', $orderId)->firstOrFail();
            
            // Only allow deletion of cancelled orders or pending orders
            if (!in_array($order->status, ['cancelled', 'pending'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Only cancelled or pending orders can be deleted'
                ], 400);
            }
            
            $order->delete();

            return response()->json([
                'success' => true,
                'message' => 'Order deleted successfully'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete order: ' . $e->getMessage()
            ], 500);
        }
    }
}