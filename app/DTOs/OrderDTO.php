<?php

namespace App\DTOs;

class OrderDTO
{
    public function __construct(
        public readonly array $items,
        public readonly string $customerName,
        public readonly ?string $customerEmail,
        public readonly ?string $customerPhone,
        public readonly string $orderType,
        public readonly ?string $specialInstructions,
        public readonly string $paymentMethod,
        public readonly ?string $transactionId = null,
        public readonly ?int $userId = null
    ) {}

    public function getSubtotal(): float
    {
        return array_reduce($this->items, function ($total, $item) {
            return $total + ($item['price'] * $item['quantity']);
        }, 0);
    }

    public function getTax(): float
    {
        return $this->getSubtotal() * 0.1; // 10% tax
    }

    public function getTotal(): float
    {
        return $this->getSubtotal() + $this->getTax();
    }

    public function getTotalItems(): int
    {
        return array_reduce($this->items, function ($total, $item) {
            return $total + $item['quantity'];
        }, 0);
    }

    public function toArray(): array
    {
        return [
            'items' => $this->items,
            'customer_name' => $this->customerName,
            'customer_email' => $this->customerEmail,
            'customer_phone' => $this->customerPhone,
            'order_type' => $this->orderType,
            'special_instructions' => $this->specialInstructions,
            'payment_method' => $this->paymentMethod,
            'transaction_id' => $this->transactionId,
            'user_id' => $this->userId,
            'subtotal' => $this->getSubtotal(),
            'tax' => $this->getTax(),
            'total' => $this->getTotal()
        ];
    }

    public static function fromRequest(array $requestData): self
    {
        return new self(
            items: $requestData['items'] ?? [],
            customerName: $requestData['customer_name'] ?? '',
            customerEmail: $requestData['customer_email'] ?? null,
            customerPhone: $requestData['customer_phone'] ?? null,
            orderType: $requestData['order_type'] ?? 'dine_in',
            specialInstructions: $requestData['special_instructions'] ?? null,
            paymentMethod: $requestData['payment_method'] ?? 'cash',
            transactionId: $requestData['transaction_id'] ?? null,
            userId: $requestData['user_id'] ?? null
        );
    }
}