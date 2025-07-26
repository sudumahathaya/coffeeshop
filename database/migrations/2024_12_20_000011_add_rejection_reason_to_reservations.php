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
        Schema::table('reservations', function (Blueprint $table) {
            $table->text('rejection_reason')->nullable()->after('special_requests');
            $table->text('admin_notes')->nullable()->after('rejection_reason');
            $table->timestamp('approved_at')->nullable()->after('updated_at');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null')->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropColumn(['rejection_reason', 'admin_notes', 'approved_at', 'approved_by']);
        });
    }
};