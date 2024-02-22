<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parvarbandi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'dam_id',
        'dam_type',
        'expire_date',
    ];

    public function dam()
    {
        return $this->belongsTo(Dam::class);
    }
}
