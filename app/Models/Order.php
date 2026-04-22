<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $fillable = ['user_id', 'rice_id', 'quantity', 'total_amount'];

    protected $casts = [
        'quantity' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function rice(): BelongsTo
    {
        return $this->belongsTo(Rice::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }
}
