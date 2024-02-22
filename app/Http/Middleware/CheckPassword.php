<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPassword
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()->changed_password != null) {
            $chang_password = auth()->user()->changed_password;
            $nowDate = Carbon::now();
            if (verta($chang_password)->diffHours($nowDate) <= 24) {
                return abort(401);
            } else
                return $next($request);
        } else
            return $next($request);
    }
}
