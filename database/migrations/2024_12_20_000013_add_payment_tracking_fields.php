<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add additional payment tracking fields to orders table
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_gateway')->default('simulation')->after('payment_status');
            $table->decimal('processing_fee', 8, 2)->default(0)->after('payment_gateway');
            $table->json('payment_details')->nullable()->after('processing_fee');
            $table->timestamp('payment_completed_at')->nullable()->after('payment_details');
            $table->string('refund_id')->nullable()->after('payment_completed_at');
            $table->decimal('refund_amount', 8, 2)->nullable()->after('refund_id');
            $table->timestamp('refunded_at')->nullable()->after('refund_amount');
            $table->string('refund_reason')->nullable()->after('refunded_at');
        });

        // Create payment_transactions table for detailed tracking
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id')->unique();
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('set null');
            $table->string('payment_gateway')->default('simulation');
            $table->enum('payment_method', ['card', 'mobile', 'bank_transfer', 'digital_wallet', 'cash']);
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('LKR');
            $table->decimal('processing_fee', 8, 2)->default(0);
            $table->enum('status', ['pending', 'processing', 'completed', 'failed', 'cancelled', 'refunded'])->default('pending');
            $table->json('gateway_response')->nullable();
            $table->json('customer_details')->nullable();
            $table->json('payment_details')->nullable();
            $table->string('failure_reason')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();

            // Add indexes for better performance
            $table->index(['status', 'created_at']);
            $table->index(['payment_method', 'status']);
            $table->index(['transaction_id', 'status']);
        });

        // Create payment_refunds table
        Schema::create('payment_refunds', function (Blueprint $table) {
            $table->id();
            $table->string('refund_id')->unique();
            $table->foreignId('transaction_id')->constrained('payment_transactions')->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->string('reason')->nullable();
            $table->enum('status', ['pending', 'processing', 'completed', 'failed'])->default('pending');
            $table->json('gateway_response')->nullable();
            $table->foreignId('processed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();

            // Add indexes
            $table->index(['status', 'created_at']);
            $table->index(['refund_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_refunds');
        Schema::dropIfExists('payment_transactions');
        
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'payment_gateway',
                'processing_fee', 
                'payment_details',
                'payment_completed_at',
                'refund_id',
                'refund_amount',
                'refunded_at',
                'refund_reason'
            ]);
        });
    }
};