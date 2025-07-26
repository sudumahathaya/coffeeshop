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
        // Add data attributes for better tracking in admin tables
        Schema::table('orders', function (Blueprint $table) {
            $table->index(['status', 'created_at']);
            $table->index(['user_id', 'status']);
        });

        Schema::table('reservations', function (Blueprint $table) {
            $table->index(['status', 'reservation_date']);
            $table->index(['user_id', 'status']);
        });

        Schema::table('profile_change_requests', function (Blueprint $table) {
            $table->index(['status', 'created_at']);
            $table->index(['user_id', 'status']);
        });

        Schema::table('reservation_change_requests', function (Blueprint $table) {
            $table->index(['status', 'created_at']);
            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['status', 'created_at']);
            $table->dropIndex(['user_id', 'status']);
        });

        Schema::table('reservations', function (Blueprint $table) {
            $table->dropIndex(['status', 'reservation_date']);
            $table->dropIndex(['user_id', 'status']);
        });

        Schema::table('profile_change_requests', function (Blueprint $table) {
            $table->dropIndex(['status', 'created_at']);
            $table->dropIndex(['user_id', 'status']);
        });

        Schema::table('reservation_change_requests', function (Blueprint $table) {
            $table->dropIndex(['status', 'created_at']);
            $table->dropIndex(['user_id', 'status']);
        });
    }
};