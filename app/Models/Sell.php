<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sell extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'dam_id',
        'dam_type',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dam()
    {
        return $this->belongsTo(Dam::class);
    }
}
