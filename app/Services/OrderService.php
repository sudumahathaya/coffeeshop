<?php

namespace App\Services;

use App\DTOs\OrderDTO;
use App\Models\Order;
use App\Models\MenuItem;
use App\Models\User;
use App\Services\Enhanced\EnhancedLoyaltyService;
use App\Contracts\NotificationServiceInterface;
use App\Contracts\PaymentGatewayInterface;
use App\Services\PaymentGatewayFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderService
{
    private EnhancedLoyaltyService $loyaltyService;
    private NotificationServiceInterface $notificationService;
    private PaymentGatewayInterface $paymentGateway;

    public function __construct(
        EnhancedLoyaltyService $loyaltyService,
        NotificationServiceInterface $notificationService
    ) {
        $this->loyaltyService = $loyaltyService;
        $this->notificationService = $notificationService;
        $this->paymentGateway = PaymentGatewayFactory::create('simulation');
    }

    /**
     * Create a new order
     */
    public function createOrder(OrderDTO $orderDTO): array
    {
        try {
            DB::beginTransaction();

            // Validate order items
            $this->validateOrderItems($orderDTO->items);

            // Generate order ID
            $orderId = $this->generateOrderId();

            // Create order
            $order = Order::create(array_merge($orderDTO->toArray(), [
                'order_id' => $orderId,
                'status' => 'confirmed'
            ]));

            // Award loyalty points if user is authenticated
            $pointsEarned = 0;
            if ($orderDTO->userId) {
                $pointsEarned = $this->loyaltyService->awardPointsForOrder($order);
            }

            // Send confirmation notification
            if ($orderDTO->userId) {
                $user = User::find($orderDTO->userId);
                if ($user) {
                    $this->notificationService->sendOrderConfirmation($user, [
                        'order_id' => $orderId,
                        'total' => $orderDTO->getTotal(),
                        'items' => $orderDTO->items
                    ]);
                }
            }

            DB::commit();

            Log::info('Order created successfully', [
                'order_id' => $orderId,
                'user_id' => $orderDTO->userId,
                'total_amount' => $orderDTO->getTotal(),
                'points_earned' => $pointsEarned
            ]);

            return [
                'success' => true,
                'order_id' => $orderId,
                'order' => $order,
                'points_earned' => $pointsEarned,
                'total_amount' => $orderDTO->getTotal()
            ];

        } catch (\Exception $e) {
            DB::rollback();
            
            Log::error('Order creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => $orderDTO->userId
            ]);

            return [
                'success' => false,
                'message' => 'Failed to create order: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Update order status
     */
    public function updateOrderStatus(string $orderId, string $status): array
    {
        try {
            $order = Order::where('order_id', $orderId)->firstOrFail();
            $oldStatus = $order->status;
            
            $order->update(['status' => $status]);

            if ($status === 'completed') {
                $order->update(['completed_at' => now()]);
            }

            // Broadcast real-time update
            broadcast(new \App\Events\OrderUpdated($order))->toOthers();

            Log::info('Order status updated', [
                'order_id' => $orderId,
                'old_status' => $oldStatus,
                'new_status' => $status
            ]);

            return [
                'success' => true,
                'order' => $order,
                'old_status' => $oldStatus,
                'new_status' => $status
            ];

        } catch (\Exception $e) {
            Log::error('Failed to update order status', [
                'order_id' => $orderId,
                'status' => $status,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Failed to update order status'
            ];
        }
    }

    /**
     * Process payment for order
     */
    public function processPayment(Order $order, array $paymentData): array
    {
        try {
            $paymentResult = $this->paymentGateway->processPayment(array_merge($paymentData, [
                'amount' => $order->total,
                'order_id' => $order->order_id,
                'customer_name' => $order->customer_name
            ]));

            if ($paymentResult['success']) {
                $order->update([
                    'payment_status' => 'completed',
                    'transaction_id' => $paymentResult['transaction_id']
                ]);
            }

            return $paymentResult;

        } catch (\Exception $e) {
            Log::error('Payment processing failed', [
                'order_id' => $order->order_id,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Payment processing failed'
            ];
        }
    }

    /**
     * Get user's order history
     */
    public function getUserOrderHistory(int $userId, int $limit = 10): array
    {
        try {
            $orders = Order::where('user_id', $userId)
                ->with('loyaltyPoints')
                ->latest()
                ->take($limit)
                ->get();

            return [
                'success' => true,
                'orders' => $orders,
                'total_orders' => Order::where('user_id', $userId)->count(),
                'total_spent' => Order::where('user_id', $userId)->sum('total')
            ];

        } catch (\Exception $e) {
            Log::error('Failed to get user order history', [
                'user_id' => $userId,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Failed to retrieve order history'
            ];
        }
    }

    /**
     * Validate order items
     */
    private function validateOrderItems(array $items): void
    {
        if (empty($items)) {
            throw new \InvalidArgumentException('Order must contain at least one item');
        }

        foreach ($items as $item) {
            if (!isset($item['id']) || !isset($item['quantity'])) {
                throw new \InvalidArgumentException('Invalid item data');
            }

            $menuItem = MenuItem::find($item['id']);
            if (!$menuItem || $menuItem->status !== 'active') {
                throw new \InvalidArgumentException("Menu item {$item['id']} is not available");
            }

            if ($item['quantity'] <= 0 || $item['quantity'] > 10) {
                throw new \InvalidArgumentException('Invalid quantity for item');
            }
        }
    }

    /**
     * Generate unique order ID
     */
    private function generateOrderId(): string
    {
        return 'ORD' . str_pad(Order::count() + 1, 6, '0', STR_PAD_LEFT);
    }
}