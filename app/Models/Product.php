<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'detail',
        'type',
        'original_price',
        'discount_price',
        'in_stock',
        'status',
        'user_id'
    ];

    function user(){
        return $this->belongsTo(User::class);
    }
}
