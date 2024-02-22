<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'size',
        'path',
        'url',
        'format',
    ];

    public function dams()
    {
        $this->morphedByMany(Dam::class, 'galleryables');
    }

    public function damvizhes()
    {
        $this->morphedByMany(Damvizhe::class, 'galleryables');
    }
}
