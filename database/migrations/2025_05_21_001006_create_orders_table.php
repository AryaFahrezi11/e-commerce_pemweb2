<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Relasi dengan tabel customers
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');

            // Informasi pelanggan
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();

            // Alamat lengkap
            $table->string('address');
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('postal_code')->nullable();

            // Informasi pesanan
            $table->date('order_date')->default(now());
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('shipping_cost', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2)->default(0.00);

            // Metode pembayaran
            $table->enum('payment_method', ['cod', 'transfer'])->default('cod');

            // Status pesanan
            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled'])->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Rollback migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
