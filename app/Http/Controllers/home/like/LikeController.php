<?php

namespace App\Http\Controllers\home\like;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(100);
        }
        $res = [];
        if ($result = hasLike($request->likeable_id, $request->likeable_type)) {
            $result->delete();
            $res['like'] = false;
        } else {
            auth()->user()->likes()->create([
                'likeable_id' => $request->likeable_id,
                'likeable_type' => $request->likeable_type,
            ]);
            $res['like'] = true;
        }
        return $res;
    }
}
