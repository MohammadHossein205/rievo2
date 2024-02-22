<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Authimage extends Model
{
    use HasFactory;

    protected $fillable = [
        'login_image',
        'register_image',
    ];
}
