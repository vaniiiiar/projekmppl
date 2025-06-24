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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->enum('order_type', ['dine_in', 'take_away']);
            $table->integer('table_number')->nullable(); // hanya diisi jika dine_in
            $table->enum('status', ['pending', 'acc', 'decline'])->default('pending');
            $table->enum('transaction_status', ['pending', 'confirmed'])->default('pending');
            $table->decimal('subtotal', 10, 2)->default(0); // total dari semua item
            $table->decimal('tax', 10, 2)->default(0); // 5% dari subtotal
            $table->decimal('total_price', 10, 2)->default(0); // subtotal + tax
            $table->string('payment_proof')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
