<?php

use App\Models\Like;
use Illuminate\Support\Facades\Auth;

function hasLike($id, $type)
{
    $check = Like::where('user_id', Auth::id())
        ->where('likeable_id', $id)
        ->where('likeable_type', $type)->first();
    return $check ?: false;
}

function checkURL($url): bool
{
    if (is_array($url)) {
        $result = collect($url)->filter(function ($item) {
            return url()->to($item) == url()->current();
        })->first();
        return $result ? true : false;
    } else {
        return url()->to($url) == url()->current() ? true : false;
    }
}
