<?php

namespace App\Services\PaymentGateways;

use App\Contracts\PaymentGatewayInterface;
use Illuminate\Support\Facades\Log;

abstract class AbstractPaymentGateway implements PaymentGatewayInterface
{
    protected string $gatewayName;
    protected array $config;
    protected array $supportedMethods;

    public function __construct(array $config = [])
    {
        $this->config = $config;
        $this->initialize();
    }

    /**
     * Initialize gateway-specific configuration
     */
    abstract protected function initialize(): void;

    /**
     * Validate payment data
     */
    protected function validatePaymentData(array $paymentData): void
    {
        $requiredFields = ['amount', 'currency', 'customer_name'];
        
        foreach ($requiredFields as $field) {
            if (!isset($paymentData[$field]) || empty($paymentData[$field])) {
                throw new \InvalidArgumentException("Missing required field: {$field}");
            }
        }

        if ($paymentData['amount'] <= 0) {
            throw new \InvalidArgumentException("Amount must be greater than 0");
        }
    }

    /**
     * Log payment activity
     */
    protected function logPaymentActivity(string $action, array $data): void
    {
        Log::info("Payment Gateway [{$this->gatewayName}] - {$action}", [
            'gateway' => $this->gatewayName,
            'action' => $action,
            'data' => $data,
            'timestamp' => now()->toISOString()
        ]);
    }

    /**
     * Generate transaction ID
     */
    protected function generateTransactionId(string $method): string
    {
        $prefix = strtoupper(substr($this->gatewayName, 0, 2));
        $methodPrefix = strtoupper(substr($method, 0, 2));
        
        return "{$prefix}_{$methodPrefix}_" . date('Ymd') . '_' . uniqid();
    }

    /**
     * Calculate processing fee
     */
    protected function calculateProcessingFee(float $amount, string $method): float
    {
        $fees = $this->getProcessingFees();
        $fee = $fees[$method] ?? $fees['default'];
        
        return round(($amount * $fee['percentage'] / 100) + $fee['fixed'], 2);
    }

    /**
     * Get processing fees for different methods
     */
    abstract protected function getProcessingFees(): array;

    /**
     * Handle payment success
     */
    protected function handlePaymentSuccess(array $paymentData, string $transactionId): array
    {
        $this->logPaymentActivity('payment_success', [
            'transaction_id' => $transactionId,
            'amount' => $paymentData['amount'],
            'method' => $paymentData['method'] ?? 'unknown'
        ]);

        return [
            'success' => true,
            'transaction_id' => $transactionId,
            'amount' => $paymentData['amount'],
            'currency' => $paymentData['currency'],
            'method' => $paymentData['method'] ?? 'unknown',
            'status' => 'completed',
            'gateway' => $this->gatewayName,
            'processing_fee' => $this->calculateProcessingFee($paymentData['amount'], $paymentData['method'] ?? 'card'),
            'timestamp' => now()->toISOString()
        ];
    }

    /**
     * Handle payment failure
     */
    protected function handlePaymentFailure(array $paymentData, string $errorCode, string $errorMessage): array
    {
        $this->logPaymentActivity('payment_failure', [
            'error_code' => $errorCode,
            'error_message' => $errorMessage,
            'amount' => $paymentData['amount'],
            'method' => $paymentData['method'] ?? 'unknown'
        ]);

        return [
            'success' => false,
            'error_code' => $errorCode,
            'message' => $errorMessage,
            'gateway' => $this->gatewayName,
            'timestamp' => now()->toISOString()
        ];
    }
}