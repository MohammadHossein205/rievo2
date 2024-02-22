<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'discount_code',
        'price',
        'count',
        'end_time',
    ];

    public function users()
    {
        return $this->morphedByMany(User::class, 'discount_codeables');
    }
}
