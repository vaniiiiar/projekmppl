<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';
    protected $fillable = [
        'order_id',
        'amount',
        'method',
        'status',
        'transaction_id',
        'payment_proof',
    ];

     protected $casts = [
    'payment_proof' => 'string',
];

     public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

   
}
