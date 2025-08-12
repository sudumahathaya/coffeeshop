<?php

namespace App\Contracts;

interface PaymentGatewayInterface
{
    /**
     * Process a payment
     */
    public function processPayment(array $paymentData): array;

    /**
     * Create payment intent
     */
    public function createPaymentIntent(float $amount, string $currency = 'LKR'): array;

    /**
     * Verify payment status
     */
    public function verifyPayment(string $transactionId): array;

    /**
     * Process refund
     */
    public function processRefund(string $transactionId, ?float $amount = null, string $reason = ''): array;

    /**
     * Get supported payment methods
     */
    public function getSupportedMethods(): array;
}