<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    private $apiKey;
    private $apiUrl;

    public function __construct()
    {
        $this->apiKey = config('services.stripe.secret');
        $this->apiUrl = 'https://api.stripe.com/v1';
    }

    /**
     * Process payment using Stripe
     */
    public function processPayment($paymentToken, $amount, $currency = 'lkr')
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/x-www-form-urlencoded',
            ])->post($this->apiUrl . '/charges', [
                'amount' => $amount * 100, // Convert to cents
                'currency' => $currency,
                'source' => $paymentToken,
                'description' => 'Café Elixir Order Payment',
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                return [
                    'success' => true,
                    'transaction_id' => $data['id'],
                    'amount' => $amount,
                    'currency' => $currency,
                    'status' => $data['status']
                ];
            } else {
                Log::error('Payment failed', ['response' => $response->json()]);
                
                return [
                    'success' => false,
                    'message' => 'Payment processing failed'
                ];
            }
        } catch (\Exception $e) {
            Log::error('Payment exception', ['error' => $e->getMessage()]);
            
            return [
                'success' => false,
                'message' => 'Payment service unavailable'
            ];
        }
    }

    /**
     * Create payment intent for frontend
     */
    public function createPaymentIntent($amount, $currency = 'lkr')
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/x-www-form-urlencoded',
            ])->post($this->apiUrl . '/payment_intents', [
                'amount' => $amount * 100,
                'currency' => $currency,
                'automatic_payment_methods' => ['enabled' => true],
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                return [
                    'success' => true,
                    'client_secret' => $data['client_secret'],
                    'payment_intent_id' => $data['id']
                ];
            }

            return [
                'success' => false,
                'message' => 'Failed to create payment intent'
            ];
        } catch (\Exception $e) {
            Log::error('Payment intent creation failed', ['error' => $e->getMessage()]);
            
            return [
                'success' => false,
                'message' => 'Payment service unavailable'
            ];
        }
    }

    /**
     * Refund payment
     */
    public function refundPayment($chargeId, $amount = null)
    {
        try {
            $data = ['charge' => $chargeId];
            if ($amount) {
                $data['amount'] = $amount * 100;
            }

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/x-www-form-urlencoded',
            ])->post($this->apiUrl . '/refunds', $data);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'refund_id' => $response->json()['id']
                ];
            }

            return [
                'success' => false,
                'message' => 'Refund failed'
            ];
        } catch (\Exception $e) {
            Log::error('Refund failed', ['error' => $e->getMessage()]);
            
            return [
                'success' => false,
                'message' => 'Refund service unavailable'
            ];
        }
    }
}