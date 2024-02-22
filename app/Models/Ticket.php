<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticketgroupe_id',
        'user_id',
        'body',
    ];

    public function ticketgroupe()
    {
        return $this->belongsTo(Ticketgroupe::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
