<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip',
        'browser',
        'platform',
        'user_id',
        'viewable_id',
        'viewable_type',
    ];

    public function scopeCheckSetPage($query, $post)
    {
        return $query->where('viewable_id', $post->id)
            ->where('viewable_type', $post::class)
            ->where('created_at', '>', Carbon::today())
            ->where('ip', request()->ip());
    }

    public function viewable()
    {
        return $this->morphTo();
    }
}
