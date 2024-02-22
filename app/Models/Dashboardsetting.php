<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dashboardsetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'email_notification',
        'new_order_accept_sms',
        'new_order_cancel_sms',
    ];
}
