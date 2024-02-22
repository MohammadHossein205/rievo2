<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FactorDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'factor_id',
        'factortable_id',
        'factortable_type',
        'count',
        'monthly_money',
        'status',
    ];
}
