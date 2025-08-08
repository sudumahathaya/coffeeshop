<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SimulationPaymentService
{
    private $supportedMethods = [
        'card' => 'Credit/Debit Card',
        'mobile' => 'Mobile Payment',
        'bank_transfer' => 'Bank Transfer',
        'digital_wallet' => 'Digital Wallet'
    ];

    private $mobileProviders = [
        'dialog' => 'Dialog',
        'mobitel' => 'Mobitel', 
        'hutch' => 'Hutch',
        'airtel' => 'Airtel'
    ];

    /**
     * Process a simulated payment
     */
    public function processPayment($paymentData)
    {
        try {
            Log::info('Processing simulation payment', [
                'method' => $paymentData['method'],
                'amount' => $paymentData['amount'],
                'order_id' => $paymentData['order_id'] ?? null
            ]);

            // Simulate processing delay
            usleep(rand(500000, 2000000)); // 0.5-2 seconds

            // Generate transaction ID
            $transactionId = $this->generateTransactionId($paymentData['method']);

            // Simulate different payment outcomes
            $outcome = $this->simulatePaymentOutcome($paymentData);

            if ($outcome['success']) {
                return [
                    'success' => true,
                    'transaction_id' => $transactionId,
                    'amount' => $paymentData['amount'],
                    'currency' => $paymentData['currency'] ?? 'LKR',
                    'method' => $paymentData['method'],
                    'status' => 'completed',
                    'message' => 'Payment processed successfully',
                    'processing_fee' => $this->calculateProcessingFee($paymentData['amount'], $paymentData['method']),
                    'timestamp' => now()->toISOString()
                ];
            } else {
                return [
                    'success' => false,
                    'error_code' => $outcome['error_code'],
                    'message' => $outcome['message'],
                    'method' => $paymentData['method'],
                    'amount' => $paymentData['amount'],
                    'timestamp' => now()->toISOString()
                ];
            }

        } catch (\Exception $e) {
            Log::error('Simulation payment processing failed', [
                'error' => $e->getMessage(),
                'payment_data' => $paymentData
            ]);

            return [
                'success' => false,
                'error_code' => 'SYSTEM_ERROR',
                'message' => 'Payment system temporarily unavailable',
                'timestamp' => now()->toISOString()
            ];
        }
    }

    /**
     * Create payment intent for frontend
     */
    public function createPaymentIntent($amount, $currency = 'LKR', $method = 'card')
    {
        try {
            $intentId = 'pi_sim_' . Str::random(24);
            $clientSecret = $intentId . '_secret_' . Str::random(16);

            Log::info('Created simulation payment intent', [
                'intent_id' => $intentId,
                'amount' => $amount,
                'currency' => $currency,
                'method' => $method
            ]);

            return [
                'success' => true,
                'payment_intent_id' => $intentId,
                'client_secret' => $clientSecret,
                'amount' => $amount,
                'currency' => $currency,
                'method' => $method,
                'expires_at' => now()->addMinutes(30)->toISOString()
            ];

        } catch (\Exception $e) {
            Log::error('Failed to create payment intent', ['error' => $e->getMessage()]);

            return [
                'success' => false,
                'message' => 'Failed to create payment intent'
            ];
        }
    }

    /**
     * Verify payment status
     */
    public function verifyPayment($transactionId)
    {
        try {
            // Simulate verification delay
            usleep(rand(200000, 800000)); // 0.2-0.8 seconds

            // Extract method from transaction ID
            $method = $this->extractMethodFromTransactionId($transactionId);

            return [
                'success' => true,
                'transaction_id' => $transactionId,
                'status' => 'verified',
                'method' => $method,
                'verified_at' => now()->toISOString()
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Verification failed'
            ];
        }
    }

    /**
     * Process refund
     */
    public function processRefund($transactionId, $amount = null, $reason = 'Customer request')
    {
        try {
            $refundId = 'rf_sim_' . Str::random(20);

            Log::info('Processing simulation refund', [
                'transaction_id' => $transactionId,
                'refund_id' => $refundId,
                'amount' => $amount,
                'reason' => $reason
            ]);

            // Simulate refund processing
            usleep(rand(1000000, 3000000)); // 1-3 seconds

            return [
                'success' => true,
                'refund_id' => $refundId,
                'transaction_id' => $transactionId,
                'amount' => $amount,
                'status' => 'refunded',
                'reason' => $reason,
                'processed_at' => now()->toISOString()
            ];

        } catch (\Exception $e) {
            Log::error('Simulation refund failed', [
                'error' => $e->getMessage(),
                'transaction_id' => $transactionId
            ]);

            return [
                'success' => false,
                'message' => 'Refund processing failed'
            ];
        }
    }

    /**
     * Get supported payment methods
     */
    public function getSupportedMethods()
    {
        return [
            'success' => true,
            'methods' => $this->supportedMethods,
            'mobile_providers' => $this->mobileProviders
        ];
    }

    /**
     * Get payment method fees
     */
    public function getPaymentFees()
    {
        return [
            'success' => true,
            'fees' => [
                'card' => ['percentage' => 2.9, 'fixed' => 30],
                'mobile' => ['percentage' => 1.5, 'fixed' => 10],
                'bank_transfer' => ['percentage' => 0.5, 'fixed' => 25],
                'digital_wallet' => ['percentage' => 2.0, 'fixed' => 15]
            ]
        ];
    }

    /**
     * Private helper methods
     */
    private function generateTransactionId($method)
    {
        $prefix = match($method) {
            'card' => 'CC',
            'mobile' => 'MP',
            'bank_transfer' => 'BT',
            'digital_wallet' => 'DW',
            default => 'TX'
        };

        return $prefix . '_sim_' . date('Ymd') . '_' . Str::random(12);
    }

    private function simulatePaymentOutcome($paymentData)
    {
        // Simulate different scenarios based on amount and method
        $amount = $paymentData['amount'];
        $method = $paymentData['method'];
        
        // Check for specific test card numbers
        if (isset($paymentData['card_number'])) {
            $cardNumber = preg_replace('/\D/', '', $paymentData['card_number']);
            
            // Test card for successful payment
            if ($cardNumber === '4242424242424242') {
                return ['success' => true];
            }
            
            // Test card for declined payment
            if ($cardNumber === '4000000000000002') {
                return [
                    'success' => false,
                    'error_code' => 'CARD_DECLINED',
                    'message' => 'Your card was declined. Please try a different payment method.'
                ];
            }
        }

        // Test scenarios for demonstration
        if ($amount == 9999.99) {
            return [
                'success' => false,
                'error_code' => 'INSUFFICIENT_FUNDS',
                'message' => 'Insufficient funds in account'
            ];
        }

        if ($amount == 8888.88) {
            return [
                'success' => false,
                'error_code' => 'CARD_DECLINED',
                'message' => 'Card was declined by issuer'
            ];
        }

        if ($amount == 7777.77) {
            return [
                'success' => false,
                'error_code' => 'NETWORK_ERROR',
                'message' => 'Network timeout - please try again'
            ];
        }

        // Mobile payment specific scenarios
        if ($method === 'mobile') {
            $provider = $paymentData['provider'] ?? 'dialog';
            
            if ($provider === 'hutch' && $amount > 5000) {
                return [
                    'success' => false,
                    'error_code' => 'LIMIT_EXCEEDED',
                    'message' => 'Transaction limit exceeded for Hutch payments'
                ];
            }
        }

        // Default success rate: 95%
        $successRate = 0.95;
        
        // Adjust success rate based on amount
        if ($amount > 10000) {
            $successRate = 0.90; // Slightly lower for high amounts
        }

        if (rand(1, 100) <= ($successRate * 100)) {
            return ['success' => true];
        } else {
            $errors = [
                ['error_code' => 'TIMEOUT', 'message' => 'Payment gateway timeout'],
                ['error_code' => 'INVALID_CARD', 'message' => 'Invalid card details'],
                ['error_code' => 'EXPIRED_CARD', 'message' => 'Card has expired'],
                ['error_code' => 'NETWORK_ERROR', 'message' => 'Network connection failed']
            ];

            return $errors[array_rand($errors)];
        }
    }

    private function calculateProcessingFee($amount, $method)
    {
        $fees = [
            'card' => ['percentage' => 2.9, 'fixed' => 30],
            'mobile' => ['percentage' => 1.5, 'fixed' => 10],
            'bank_transfer' => ['percentage' => 0.5, 'fixed' => 25],
            'digital_wallet' => ['percentage' => 2.0, 'fixed' => 15]
        ];

        $fee = $fees[$method] ?? $fees['card'];
        
        return round(($amount * $fee['percentage'] / 100) + $fee['fixed'], 2);
    }

    private function extractMethodFromTransactionId($transactionId)
    {
        $prefix = substr($transactionId, 0, 2);
        
        return match($prefix) {
            'CC' => 'card',
            'MP' => 'mobile',
            'BT' => 'bank_transfer',
            'DW' => 'digital_wallet',
            default => 'unknown'
        };
    }

    /**
     * Simulate mobile payment OTP verification
     */
    public function sendMobileOTP($phoneNumber, $provider)
    {
        try {
            $otpCode = rand(100000, 999999);
            
            Log::info('Simulation OTP sent', [
                'phone' => $phoneNumber,
                'provider' => $provider,
                'otp' => $otpCode // In real system, never log OTP
            ]);

            return [
                'success' => true,
                'message' => 'OTP sent successfully',
                'otp_id' => 'otp_sim_' . Str::random(16),
                'expires_in' => 300, // 5 minutes
                'test_otp' => $otpCode // Only for simulation
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Failed to send OTP'
            ];
        }
    }

    /**
     * Verify mobile payment OTP
     */
    public function verifyMobileOTP($otpId, $otpCode, $testOtp = null)
    {
        try {
            // In simulation, we accept the test OTP or common test codes
            $validCodes = ['123456', '000000', $testOtp];
            
            if (in_array($otpCode, $validCodes)) {
                return [
                    'success' => true,
                    'message' => 'OTP verified successfully',
                    'verified_at' => now()->toISOString()
                ];
            } else {
                return [
                    'success' => false,
                    'error_code' => 'INVALID_OTP',
                    'message' => 'Invalid OTP code'
                ];
            }

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'OTP verification failed'
            ];
        }
    }
}