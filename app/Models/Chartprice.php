<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chartprice extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'price',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
