<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bankcard extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bankname',
        'image',
        'cardnumber',
        'shabanumber',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
