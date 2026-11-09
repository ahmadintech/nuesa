<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique(); // receipt number
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->decimal('amount', 10, 2);
            $table->string('academic_session')->default('2025/2026');
            $table->string('payment_type')->default('Departmental Dues'); // Departmental Dues, ID Card, Convention
            $table->string('payment_channel')->default('Debit Card'); // Debit Card, Bank Transfer, USSD
            $table->string('reference')->unique();
            $table->enum('status', ['successful', 'pending', 'failed'])->default('pending');
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
