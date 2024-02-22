<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HusbandryText extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_text',
        'title_description',
    ];
}
