<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rice extends Model
{
    protected $fillable = ['name', 'price_per_kg', 'stock', 'description'];

    protected $casts = [
        'price_per_kg' => 'decimal:2',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
