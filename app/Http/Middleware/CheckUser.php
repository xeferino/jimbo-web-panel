<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {

        $token = $request->user()->currentAccessToken()->token;
        $sanctum = DB::table('personal_access_tokens')
                    ->where('token', $token)
                    ->where('tokenable_id', $request->user()->id)
                    ->first();

        if ($sanctum) {
            if($sanctum->token == $token)
                return $next($request);
        }
        return abort(403);
    }
}
