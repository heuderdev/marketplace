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
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id');
            $table->string('mercado_pago_id', 191)->nullable();
            $table->string('payment_method', 32)->nullable();
            $table->string('status', 32)->default('initiated');
            $table->decimal('amount', 10, 2);
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders');
            $table->index('order_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
