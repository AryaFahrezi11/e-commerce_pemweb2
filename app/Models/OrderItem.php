<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class OrderItem extends Model
{
    // Gunakan nama tabel 'order_items' agar konsisten dengan migrasi
    protected $table = 'order_items';

    // Kolom yang bisa diisi secara massal
    protected $fillable = [
        'order_id',
        'itemable_id',
        'itemable_type',
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
     * Relasi polymorphic: OrderItem ini berelasi ke itemable (Product, dll)
     */
    public function itemable(): MorphTo
    {
        return $this->morphTo();
    }
}
