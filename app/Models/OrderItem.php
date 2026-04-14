<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $fillable = [
        'product_id',
        'order_id',
        'quantity',
        'unit_price',
        'total_price',
    ];

    protected $casts = [
        'product_id' => 'integer',
        'order_id' => 'integer',
        'quantity' => 'integer',
        'unit_price' => 'decimal',
        'total_price' => 'decimal',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
