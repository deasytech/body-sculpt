<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->restrictOnDelete();
            $table->string('order_number')->unique();
            $table->enum('status', ['pending', 'paid', 'fulfilled', 'cancelled'])->default('pending');
            $table->unsignedInteger('subtotal');
            $table->unsignedInteger('discount')->default(0);
            $table->unsignedInteger('total');
            $table->foreignId('promo_code_id')->nullable()->constrained()->nullOnDelete();
            $table->string('payment_gateway')->nullable();
            $table->string('payment_reference')->nullable();
            $table->timestamps();

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
