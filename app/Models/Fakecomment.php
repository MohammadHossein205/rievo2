<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fakecomment extends Model
{
    use HasFactory;

    protected $fillable = [
        'namefamily',
        'image',
        'body',
        'status',
    ];
}
