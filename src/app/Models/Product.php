<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $fillable = ([
        'category_id',
        'name',
        'description',
        'price',
        'is_available',
        'customizations',
        'image',
    ]);

    protected $casts = [
        'customizations' => 'array',
        'has_size' => 'boolean',
        'is_available' => 'boolean'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
