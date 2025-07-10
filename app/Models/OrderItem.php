<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    // Gunakan nama tabel 'order_items' agar konsisten dengan migrasi
    protected $table = 'order_items';

    // Kolom yang bisa diisi secara massal
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',    // harga satuan saat order dibuat
        'total',    // quantity * price
    ];

    /**
     * Relasi: OrderItem ini milik satu Order
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Relasi: OrderItem ini berelasi ke satu Product
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
