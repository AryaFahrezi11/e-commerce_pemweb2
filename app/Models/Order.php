<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'customer_id',
        'name',
        'email',
        'phone',
        'address',
        'city',
        'province',
        'postal_code',
        'order_date',
        'subtotal',
        'shipping_cost',
        'total_amount',
        'payment_method',
        'status',
    ];

    protected $casts = [
        'order_date'     => 'datetime',
        'subtotal'       => 'integer',
        'shipping_cost'  => 'integer',
        'total_amount'   => 'integer',
    ];

    /**
     * Relasi: Order dimiliki oleh satu Customer
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Relasi: Order memiliki banyak Item (OrderDetail)
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
