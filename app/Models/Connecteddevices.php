<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Connecteddevices extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'browser_name',
        'device',
        'ip',
        'user_location',
        'status',
    ];
}
