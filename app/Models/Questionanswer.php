<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questionanswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'body',
        'parent_id',
        'questionanswerable_id',
        'questionanswerable_type',
        'status',
    ];

    public function questionanswerable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dam()
    {
        return $this->belongsTo(Dam::class);
    }
}
