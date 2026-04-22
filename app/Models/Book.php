<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'book_name',
        'book_author',
        'book_stock',
        'book_date',
    ];

    protected $casts = [
        'book_date' => 'date',
    ];
}
