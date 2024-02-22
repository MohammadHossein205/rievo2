<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buydam extends Model
{
    use HasFactory;

    protected $fillable = [
            'user_id',
            'dam_id',
            'dam_count',
        ];
}
