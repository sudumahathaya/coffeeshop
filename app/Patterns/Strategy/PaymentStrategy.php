<?php

namespace App\Patterns\Strategy;

abstract class PaymentStrategy
{
    protected string $methodName;
    protected array $config;

    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    /**
     * Process payment using this strategy
     */
    abstract public function processPayment(array $paymentData): array;

    /**
     * Validate payment data for this strategy
     */
    abstract public function validatePaymentData(array $paymentData): void;

    /**
     * Get processing fee for this payment method
     */
    abstract public function getProcessingFee(float $amount): float;

    /**
     * Get method name
     */
    public function getMethodName(): string
    {
        return $this->methodName;
    }

    /**
     * Check if payment method is available
     */
    public function isAvailable(): bool
    {
        return true; // Override in specific strategies if needed
    }

    /**
     * Get method display information
     */
    public function getMethodInfo(): array
    {
        return [
            'name' => $this->methodName,
            'available' => $this->isAvailable(),
            'processing_fee' => $this->getProcessingFee(1000), // Sample fee for Rs. 1000
        ];
    }
}