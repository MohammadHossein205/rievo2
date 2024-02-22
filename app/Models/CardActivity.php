<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'payment_type',
        'price',
        'wage',
        'card_number',
        'res_number',
        'status',
    ];
}
