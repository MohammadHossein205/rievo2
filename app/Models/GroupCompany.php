<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupCompany extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'name',
        'english_name',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function dams()
    {
        return $this->hasMany(Dam::class);
    }
}
