<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'paymentable_id',
        'paymentable_type',
        'description',
        'count',
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'id', 'payment_id');
    }

    public function dam()
    {
        return $this->belongsTo(Dam::class);
    }
}
