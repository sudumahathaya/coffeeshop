<?php

namespace App\Patterns\Observer;

use App\Models\Order;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        \Log::info('Order created via observer', [
            'order_id' => $order->order_id,
            'customer' => $order->customer_name,
            'total' => $order->total
        ]);

        // Send real-time notification
        if ($order->user_id) {
            broadcast(new \App\Events\OrderUpdated($order))->toOthers();
        }
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        \Log::info('Order updated via observer', [
            'order_id' => $order->order_id,
            'changes' => $order->getChanges()
        ]);

        // Broadcast status changes
        if ($order->wasChanged('status')) {
            broadcast(new \App\Events\OrderUpdated($order))->toOthers();
        }
    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Order $order): void
    {
        \Log::info('Order deleted via observer', [
            'order_id' => $order->order_id,
            'customer' => $order->customer_name
        ]);
    }
}