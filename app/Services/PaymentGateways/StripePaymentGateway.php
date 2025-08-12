<?php

namespace App\Services\PaymentGateways;

use Illuminate\Support\Facades\Http;

class StripePaymentGateway extends AbstractPaymentGateway
{
    private string $apiKey;
    private string $apiUrl;

    protected function initialize(): void
    {
        $this->gatewayName = 'stripe';
        $this->apiKey = config('services.stripe.secret');
        $this->apiUrl = 'https://api.stripe.com/v1';
        $this->supportedMethods = [
            'card' => 'Credit/Debit Card',
            'digital_wallet' => 'Digital Wallet'
        ];
    }

    public function processPayment(array $paymentData): array
    {
        try {
            $this->validatePaymentData($paymentData);
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/x-www-form-urlencoded',
            ])->post($this->apiUrl . '/charges', [
                'amount' => $paymentData['amount'] * 100, // Convert to cents
                'currency' => strtolower($paymentData['currency']),
                'source' => $paymentData['payment_token'] ?? 'tok_visa',
                'description' => 'Café Elixir Order Payment',
                'metadata' => [
                    'customer_name' => $paymentData['customer_name'],
                    'order_id' => $paymentData['order_id'] ?? null
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $this->handlePaymentSuccess($paymentData, $data['id']);
            } else {
                $error = $response->json();
                return $this->handlePaymentFailure(
                    $paymentData,
                    $error['error']['code'] ?? 'PAYMENT_FAILED',
                    $error['error']['message'] ?? 'Payment processing failed'
                );
            }

        } catch (\Exception $e) {
            return $this->handlePaymentFailure(
                $paymentData,
                'SYSTEM_ERROR',
                'Payment system unavailable: ' . $e->getMessage()
            );
        }
    }

    public function createPaymentIntent(float $amount, string $currency = 'LKR'): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/x-www-form-urlencoded',
            ])->post($this->apiUrl . '/payment_intents', [
                'amount' => $amount * 100,
                'currency' => strtolower($currency),
                'automatic_payment_methods' => ['enabled' => true],
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                return [
                    'success' => true,
                    'payment_intent_id' => $data['id'],
                    'client_secret' => $data['client_secret'],
                    'gateway' => $this->gatewayName
                ];
            }

            return [
                'success' => false,
                'message' => 'Failed to create payment intent'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Payment service unavailable: ' . $e->getMessage()
            ];
        }
    }

    public function verifyPayment(string $transactionId): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
            ])->get($this->apiUrl . "/charges/{$transactionId}");

            if ($response->successful()) {
                $data = $response->json();
                
                return [
                    'success' => true,
                    'transaction_id' => $transactionId,
                    'status' => $data['status'],
                    'gateway' => $this->gatewayName,
                    'verified_at' => now()->toISOString()
                ];
            }

            return [
                'success' => false,
                'message' => 'Transaction not found'
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
            $data = ['charge' => $transactionId];
            if ($amount) {
                $data['amount'] = $amount * 100;
            }
            if ($reason) {
                $data['reason'] = $reason;
            }

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/x-www-form-urlencoded',
            ])->post($this->apiUrl . '/refunds', $data);

            if ($response->successful()) {
                $refundData = $response->json();
                
                return [
                    'success' => true,
                    'refund_id' => $refundData['id'],
                    'transaction_id' => $transactionId,
                    'amount' => $amount,
                    'status' => $refundData['status'],
                    'gateway' => $this->gatewayName,
                    'processed_at' => now()->toISOString()
                ];
            }

            return [
                'success' => false,
                'message' => 'Refund failed'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Refund service unavailable: ' . $e->getMessage()
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
            'digital_wallet' => ['percentage' => 2.5, 'fixed' => 25],
            'default' => ['percentage' => 2.9, 'fixed' => 30]
        ];
    }
}