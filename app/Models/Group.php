<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
    ];

    public function groupcompanies()
    {
        return $this->hasMany(GroupCompany::class);
    }

    public function dams()
    {
        return $this->hasMany(Dam::class);
    }

    public function damvizhes()
    {
        return $this->hasMany(Damvizhe::class);
    }

    public function chartprice()
    {
        return $this->hasOne(Chartprice::class);
    }
}
