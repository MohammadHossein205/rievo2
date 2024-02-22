<?php

namespace App\HelperTrait;

use App\Models\View;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;

trait ViewPage
{
    public function AddView($post)
    {
        $checkPage = View::checkSetPage($post)->first() ?: false;
        if (!$checkPage) {
            $agent = new Agent();
            View::create([
                'ip' => request()->ip(),
                'browser' => $agent->browser(),
                'platform' => $agent->platform(),
                'user_id' => Auth::id(),
                'viewable_id' => $post->id,
                'viewable_type' => $post::class,
            ]);
        }
    }
}
