<?php

namespace App\Services\PaymentGateways;

use Illuminate\Support\Str;

class SimulationPaymentGateway extends AbstractPaymentGateway
{
    protected function initialize(): void
    {
        $this->gatewayName = 'simulation';
        $this->supportedMethods = [
            'card' => 'Credit/Debit Card',
            'mobile' => 'Mobile Payment',
            'bank_transfer' => 'Bank Transfer',
            'digital_wallet' => 'Digital Wallet'
        ];
    }

    public function processPayment(array $paymentData): array
    {
        try {
            $this->validatePaymentData($paymentData);
            
            $this->logPaymentActivity('payment_initiated', $paymentData);

            // Simulate processing delay
            usleep(rand(500000, 2000000)); // 0.5-2 seconds

            $transactionId = $this->generateTransactionId($paymentData['method'] ?? 'card');

            // Simulate payment outcome
            $outcome = $this->simulatePaymentOutcome($paymentData);

            if ($outcome['success']) {
                return $this->handlePaymentSuccess($paymentData, $transactionId);
            } else {
                return $this->handlePaymentFailure(
                    $paymentData,
                    $outcome['error_code'],
                    $outcome['message']
                );
            }

        } catch (\Exception $e) {
            return $this->handlePaymentFailure(
                $paymentData,
                'SYSTEM_ERROR',
                'Payment system temporarily unavailable: ' . $e->getMessage()
            );
        }
    }

    public function createPaymentIntent(float $amount, string $currency = 'LKR'): array
    {
        try {
            $intentId = 'pi_sim_' . Str::random(24);
            $clientSecret = $intentId . '_secret_' . Str::random(16);

            $this->logPaymentActivity('payment_intent_created', [
                'intent_id' => $intentId,
                'amount' => $amount,
                'currency' => $currency
            ]);

            return [
                'success' => true,
                'payment_intent_id' => $intentId,
                'client_secret' => $clientSecret,
                'amount' => $amount,
                'currency' => $currency,
                'gateway' => $this->gatewayName,
                'expires_at' => now()->addMinutes(30)->toISOString()
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Failed to create payment intent: ' . $e->getMessage()
            ];
        }
    }

    public function verifyPayment(string $transactionId): array
    {
        try {
            usleep(rand(200000, 800000)); // 0.2-0.8 seconds

            $this->logPaymentActivity('payment_verified', ['transaction_id' => $transactionId]);

            return [
                'success' => true,
                'transaction_id' => $transactionId,
                'status' => 'verified',
                'gateway' => $this->gatewayName,
                'verified_at' => now()->toISOString()
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Verification failed: ' . $e->getMessage()
            ];
        }
    }

    public function processRefund(string $transactionId, ?float $amount = null, string $reason = ''): array
    {
        try {
            $refundId = 'rf_sim_' . Str::random(20);

            $this->logPaymentActivity('refund_processed', [
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
                'gateway' => $this->gatewayName,
                'processed_at' => now()->toISOString()
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Refund processing failed: ' . $e->getMessage()
            ];
        }
    }

    public function getSupportedMethods(): array
    {
        return [
            'success' => true,
            'methods' => $this->supportedMethods,
            'gateway' => $this->gatewayName
        ];
    }

    protected function getProcessingFees(): array
    {
        return [
            'card' => ['percentage' => 2.9, 'fixed' => 30],
            'mobile' => ['percentage' => 1.5, 'fixed' => 10],
            'bank_transfer' => ['percentage' => 0.5, 'fixed' => 25],
            'digital_wallet' => ['percentage' => 2.0, 'fixed' => 15],
            'default' => ['percentage' => 2.9, 'fixed' => 30]
        ];
    }

    private function simulatePaymentOutcome(array $paymentData): array
    {
        $amount = $paymentData['amount'];
        $method = $paymentData['method'] ?? 'card';

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

        // Check for test card numbers
        if (isset($paymentData['card_number'])) {
            $cardNumber = preg_replace('/\D/', '', $paymentData['card_number']);
            
            if ($cardNumber === '4000000000000002') {
                return [
                    'success' => false,
                    'error_code' => 'CARD_DECLINED',
                    'message' => 'Your card was declined. Please try a different payment method.'
                ];
            }
        }

        // Default success rate: 95%
        return rand(1, 100) <= 95 ? ['success' => true] : [
            'success' => false,
            'error_code' => 'NETWORK_ERROR',
            'message' => 'Network timeout - please try again'
        ];
    }
}