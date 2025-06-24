<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $fillable = [
        'order_code',
        'user_id',
        'product_id',
        'type',
        'status',
        'payment_status',
        'subtotal',
        'tax',
        'total',
        'table_number',
        'delivery_address',
        'notes',
        'transaction_status',
    ];

    public function getStatusLabelAttribute()
{
    return [
        'pending' => 'Menunggu Pembayaran',
        'processing' => 'Diproses',
        'completed' => 'Lunas',
        'acc' => 'Lunas', // Status yang Anda gunakan
        'cancelled' => 'Dibatalkan'
    ][$this->status] ?? $this->status;
}

public function getPaymentStatusLabelAttribute()
{
    return [
        'pending' => 'Menunggu',
        'paid' => 'Lunas',
        'failed' => 'Gagal',
        'refunded' => 'Dikembalikan'
    ][$this->payment_status] ?? $this->payment_status;
}

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function product()
{
    return $this->belongsTo(Product::class);
}

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    
}
