<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

<<<<<<< HEAD
class CreateOrdersTable extends Migration
{
=======
<<<<<<< HEAD
return new class extends Migration {
=======
return new class extends Migration
{
    /**
     * Run the migrations.
     */
>>>>>>> b97c6a5ca8591e6b961616cdb0f5a6e31cb8e65e
>>>>>>> 204e426e0e42ac9129972db765b0c41c7cb56ae7
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
<<<<<<< HEAD
            $table->string('name');
            $table->string('phone');
            $table->text('address');
            $table->string('city');
            $table->string('province');
            $table->string('postal_code');
            $table->text('note')->nullable();
            $table->enum('payment_method', ['COD', 'Transfer']);
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->unsignedBigInteger('total');
=======
<<<<<<< HEAD
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');

            $table->string('name');
            $table->string('phone');
            $table->text('address');
            $table->text('notes')->nullable();

            $table->string('payment_method');
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();

            $table->integer('subtotal')->default(0);
            $table->integer('shipping_cost')->default(0);
            $table->integer('total')->default(0);

            $table->string('status')->default('pending');
=======
            $table->foreignId('customer_id')->constrained('customers');
            $table->date('order_date');
            $table->decimal('total_amount', 10, 2)->default(0.00);
            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled'])->default('pending');
>>>>>>> b97c6a5ca8591e6b961616cdb0f5a6e31cb8e65e
>>>>>>> 204e426e0e42ac9129972db765b0c41c7cb56ae7
            $table->timestamps();
        });
    }

<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
    /**
     * Reverse the migrations.
     */
>>>>>>> b97c6a5ca8591e6b961616cdb0f5a6e31cb8e65e
>>>>>>> 204e426e0e42ac9129972db765b0c41c7cb56ae7
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
<<<<<<< HEAD
}
=======
<<<<<<< HEAD
};
=======
};
>>>>>>> b97c6a5ca8591e6b961616cdb0f5a6e31cb8e65e
>>>>>>> 204e426e0e42ac9129972db765b0c41c7cb56ae7
