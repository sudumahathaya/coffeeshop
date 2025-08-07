<?php

namespace App\Http\Controllers;

use App\Services\SimulationPaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    protected $paymentService;

    public function __construct(SimulationPaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     * Create payment intent
     */
    public function createIntent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1',
            'currency' => 'nullable|string|in:LKR,USD',
            'method' => 'nullable|string|in:card,mobile,bank_transfer,digital_wallet',
            'order_id' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid payment data',
                'errors' => $validator->errors()
            ], 422);
        }

        $result = $this->paymentService->createPaymentIntent(
            $request->amount,
            $request->currency ?? 'LKR',
            $request->method ?? 'card'
        );

        return response()->json($result);
    }

    /**
     * Process payment
     */
    public function processPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1',
            'method' => 'required|string|in:card,mobile,bank_transfer,digital_wallet',
            'currency' => 'nullable|string|in:LKR,USD',
            'order_id' => 'nullable|string',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'nullable|email',
            'customer_phone' => 'nullable|string',
            
            // Card specific fields
            'card_number' => 'required_if:method,card|nullable|string',
            'card_expiry' => 'required_if:method,card|nullable|string',
            'card_cvc' => 'required_if:method,card|nullable|string',
            'card_holder' => 'required_if:method,card|nullable|string',
            
            // Mobile payment specific fields
            'mobile_provider' => 'required_if:method,mobile|nullable|string|in:dialog,mobitel,hutch,airtel',
            'mobile_number' => 'required_if:method,mobile|nullable|string',
            
            // Bank transfer specific fields
            'bank_code' => 'required_if:method,bank_transfer|nullable|string',
            'account_number' => 'required_if:method,bank_transfer|nullable|string',
            
            // Digital wallet specific fields
            'wallet_type' => 'required_if:method,digital_wallet|nullable|string',
            'wallet_id' => 'required_if:method,digital_wallet|nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid payment data',
                'errors' => $validator->errors()
            ], 422);
        }

        $paymentData = [
            'amount' => $request->amount,
            'method' => $request->method,
            'currency' => $request->currency ?? 'LKR',
            'order_id' => $request->order_id,
            'customer' => [
                'name' => $request->customer_name,
                'email' => $request->customer_email,
                'phone' => $request->customer_phone
            ]
        ];

        // Add method-specific data
        switch ($request->method) {
            case 'card':
                $paymentData['card'] = [
                    'number' => self::maskCardNumber($request->card_number),
                    'expiry' => $request->card_expiry,
                    'holder' => $request->card_holder
                ];
                break;

            case 'mobile':
                $paymentData['mobile'] = [
                    'provider' => $request->mobile_provider,
                    'number' => $request->mobile_number
                ];
                break;

            case 'bank_transfer':
                $paymentData['bank'] = [
                    'code' => $request->bank_code,
                    'account' => self::maskAccountNumber($request->account_number)
                ];
                break;

            case 'digital_wallet':
                $paymentData['wallet'] = [
                    'type' => $request->wallet_type,
                    'id' => $request->wallet_id
                ];
                break;
        }

        $result = $this->paymentService->processPayment($paymentData);

        return response()->json($result);
    }

    /**
     * Send mobile OTP
     */
    public function sendMobileOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|string',
            'provider' => 'required|string|in:dialog,mobitel,hutch,airtel'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid data',
                'errors' => $validator->errors()
            ], 422);
        }

        $result = $this->paymentService->sendMobileOTP(
            $request->phone_number,
            $request->provider
        );

        return response()->json($result);
    }

    /**
     * Verify mobile OTP
     */
    public function verifyMobileOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp_id' => 'required|string',
            'otp_code' => 'required|string|size:6',
            'test_otp' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid OTP data',
                'errors' => $validator->errors()
            ], 422);
        }

        $result = $this->paymentService->verifyMobileOTP(
            $request->otp_id,
            $request->otp_code,
            $request->test_otp
        );

        return response()->json($result);
    }

    /**
     * Verify payment status
     */
    public function verifyPayment(Request $request, $transactionId)
    {
        $result = $this->paymentService->verifyPayment($transactionId);
        return response()->json($result);
    }

    /**
     * Process refund
     */
    public function processRefund(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'transaction_id' => 'required|string',
            'amount' => 'nullable|numeric|min:1',
            'reason' => 'nullable|string|max:500'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid refund data',
                'errors' => $validator->errors()
            ], 422);
        }

        $result = $this->paymentService->processRefund(
            $request->transaction_id,
            $request->amount,
            $request->reason ?? 'Customer request'
        );

        return response()->json($result);
    }

    /**
     * Get supported payment methods
     */
    public function getSupportedMethods()
    {
        $result = $this->paymentService->getSupportedMethods();
        return response()->json($result);
    }

    /**
     * Get payment fees
     */
    public function getPaymentFees()
    {
        $result = $this->paymentService->getPaymentFees();
        return response()->json($result);
    }

    /**
     * Helper methods
     */
    private static function maskCardNumber($cardNumber)
    {
        $cleaned = preg_replace('/\D/', '', $cardNumber);
        return substr($cleaned, 0, 4) . str_repeat('*', strlen($cleaned) - 8) . substr($cleaned, -4);
    }

    private static function maskAccountNumber($accountNumber)
    {
        return str_repeat('*', strlen($accountNumber) - 4) . substr($accountNumber, -4);
    }

    /**
     * Get payment history (for admin)
     */
    public function getPaymentHistory(Request $request)
    {
        // This would typically fetch from database
        // For simulation, return sample data
        $payments = [
            [
                'id' => 1,
                'transaction_id' => 'CC_sim_20241220_abc123def456',
                'order_id' => 'ORD000001',
                'amount' => 1240.00,
                'method' => 'card',
                'status' => 'completed',
                'customer_name' => 'John Doe',
                'created_at' => now()->subHours(2)->toISOString()
            ],
            [
                'id' => 2,
                'transaction_id' => 'MP_sim_20241220_xyz789uvw012',
                'order_id' => 'ORD000002',
                'amount' => 850.00,
                'method' => 'mobile',
                'status' => 'completed',
                'customer_name' => 'Jane Smith',
                'created_at' => now()->subHours(5)->toISOString()
            ]
        ];

        return response()->json([
            'success' => true,
            'payments' => $payments,
            'total' => count($payments)
        ]);
    }
}