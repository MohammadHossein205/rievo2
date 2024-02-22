<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'admin_show',
        'expire_date',
        'IsMonthly',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
