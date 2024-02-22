<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Getmoney extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cardnumber',
        'money',
        'resNumber',
        'status',
    ];
}
