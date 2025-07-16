<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrdersTableForCheckoutFields extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('name')->nullable()->after('customer_id');
            $table->string('phone')->nullable()->after('name');
            $table->text('address')->nullable()->after('phone');
            $table->string('city')->nullable()->after('address');
            $table->string('province')->nullable()->after('city');
            $table->string('postal_code')->nullable()->after('province');
            $table->text('note')->nullable()->after('postal_code');
            $table->enum('payment_method', ['COD', 'Transfer'])->nullable()->after('note');
            $table->string('bank_name')->nullable()->after('payment_method');
            $table->string('account_number')->nullable()->after('bank_name');
            $table->unsignedBigInteger('subtotal')->nullable()->after('account_number');
            $table->unsignedBigInteger('shipping_cost')->nullable()->after('subtotal');

            // Rename total_amount to total jika kamu ingin konsisten
            if (Schema::hasColumn('orders', 'total_amount')) {
                $table->renameColumn('total_amount', 'total');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'name', 'phone', 'address', 'city', 'province', 'postal_code',
                'note', 'payment_method', 'bank_name', 'account_number',
                'subtotal', 'shipping_cost'
            ]);

            // Rename total back if needed
            if (Schema::hasColumn('orders', 'total')) {
                $table->renameColumn('total', 'total_amount');
            }
        });
    }
}