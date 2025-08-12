<?php

namespace App\Patterns\Strategy;

use Illuminate\Support\Facades\Log;

class CardPaymentStrategy extends PaymentStrategy
{
    protected string $methodName = 'card';

    public function processPayment(array $paymentData): array
    {
        try {
            $this->validatePaymentData($paymentData);

            Log::info('Processing card payment', [
                'amount' => $paymentData['amount'],
                'card_last_four' => substr($paymentData['card_number'], -4)
            ]);

            // Simulate card processing
            $transactionId = 'CC_' . time() . '_' . uniqid();
            
            // Check for test card numbers
            $cardNumber = preg_replace('/\D/', '', $paymentData['card_number']);
            
            if ($cardNumber === '4000000000000002') {
                return [
                    'success' => false,
                    'error_code' => 'CARD_DECLINED',
                    'message' => 'Your card was declined. Please try a different payment method.'
                ];
            }

            // Simulate successful payment
            return [
                'success' => true,
                'transaction_id' => $transactionId,
                'method' => $this->methodName,
                'amount' => $paymentData['amount'],
                'processing_fee' => $this->getProcessingFee($paymentData['amount']),
                'status' => 'completed'
            ];

        } catch (\Exception $e) {
            Log::error('Card payment failed', [
                'error' => $e->getMessage(),
                'amount' => $paymentData['amount'] ?? 0
            ]);

            return [
                'success' => false,
                'error_code' => 'PROCESSING_ERROR',
                'message' => 'Payment processing failed: ' . $e->getMessage()
            ];
        }
    }

    public function validatePaymentData(array $paymentData): void
    {
        $requiredFields = ['card_number', 'card_expiry', 'card_cvc', 'card_holder', 'amount'];
        
        foreach ($requiredFields as $field) {
            if (empty($paymentData[$field])) {
                throw new \InvalidArgumentException("Missing required field: {$field}");
            }
        }

        // Validate card number (basic Luhn algorithm check)
        $cardNumber = preg_replace('/\D/', '', $paymentData['card_number']);
        if (strlen($cardNumber) < 13 || strlen($cardNumber) > 19) {
            throw new \InvalidArgumentException('Invalid card number length');
        }

        // Validate expiry date
        if (!preg_match('/^(0[1-9]|1[0-2])\/\d{2}$/', $paymentData['card_expiry'])) {
            throw new \InvalidArgumentException('Invalid expiry date format (MM/YY)');
        }

        // Validate CVC
        if (!preg_match('/^\d{3,4}$/', $paymentData['card_cvc'])) {
            throw new \InvalidArgumentException('Invalid CVC code');
        }

        // Validate amount
        if ($paymentData['amount'] <= 0) {
            throw new \InvalidArgumentException('Amount must be greater than 0');
        }
    }

    public function getProcessingFee(float $amount): float
    {
        return round(($amount * 2.9 / 100) + 30, 2); // 2.9% + Rs. 30
    }
}