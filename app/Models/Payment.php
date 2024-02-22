<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'payment_type',
        'resNumber',
        'discount',
        'discount_price',
        'price',
        'card_number',
        'IsMonthly',
        'status',
        'buyorsell',
    ];

    public function paymentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function paymentdetails()
    {
        return $this->hasMany(PaymentDetail::class);
    }
}
