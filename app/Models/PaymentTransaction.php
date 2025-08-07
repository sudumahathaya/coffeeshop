<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'order_id',
        'payment_gateway',
        'payment_method',
        'amount',
        'currency',
        'processing_fee',
        'status',
        'gateway_response',
        'customer_details',
        'payment_details',
        'failure_reason',
        'processed_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'processing_fee' => 'decimal:2',
        'gateway_response' => 'array',
        'customer_details' => 'array',
        'payment_details' => 'array',
        'processed_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function refunds()
    {
        return $this->hasMany(PaymentRefund::class, 'transaction_id');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeByMethod($query, $method)
    {
        return $query->where('payment_method', $method);
    }

    public function getFormattedAmountAttribute()
    {
        return 'Rs. ' . number_format((float) $this->amount, 2);
    }

    public function getMethodDisplayNameAttribute()
    {
        $names = [
            'card' => 'Credit/Debit Card',
            'mobile' => 'Mobile Payment',
            'bank_transfer' => 'Bank Transfer',
            'digital_wallet' => 'Digital Wallet',
            'cash' => 'Cash Payment'
        ];

        return $names[$this->payment_method] ?? $this->payment_method;
    }

    public function getTotalAmountAttribute()
    {
        return $this->amount + $this->processing_fee;
    }

    public function isRefundable()
    {
        return $this->status === 'completed' && 
               $this->refunds()->where('status', 'completed')->sum('amount') < $this->amount;
    }

    public function getRemainingRefundableAmountAttribute()
    {
        $refundedAmount = $this->refunds()->where('status', 'completed')->sum('amount');
        return $this->amount - $refundedAmount;
    }
}