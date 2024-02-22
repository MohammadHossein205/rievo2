<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contactus extends Model
{
    use HasFactory;

    protected $fillable = [
        'location_image',
        'location_link',
        'face_to_face',
        'link_way',
        'email',
        'telegram',
        'instagram',
        'whatsapp',
        'eitaa',
        'rubika',
    ];
}
