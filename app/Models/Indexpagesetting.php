<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Indexpagesetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'top_big_text',
        'top_small_text',
        'top_big_description',
        'estelam_text',
        'baner_one_image',
        'baner_one_image_link',
        'baner_two_image',
        'baner_two_image_link',
        'more_information_title',
        'more_information_text',
        'phone_text',
    ];
}
