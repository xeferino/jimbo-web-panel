<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Api\BalanceController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\Api\NotificationController;
use App\Models\Access;

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
            if($sanctum->token == $token) {
                if ($request->user()->type == 1) {
                    Access::insert([
                        'request' => $request->url(),
                        'user_id' => $request->user()->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    $access = Access::whereDate('created_at', date('Y-m-d'))->where('user_id', $request->user()->id)->count();

                    if ($access == 1){
                        $bonu = SettingController::bonus()['bonus']['diary'];
                        BalanceController::store('Bono uso diario de la aplicacion', 'credit', $bonu, 'jib',  $request->user()->id);
                        NotificationController::store('Nuevo Bono!', 'Bono de '.$bonu.' jibs por uso diario del App',  $request->user()->id);
                    }
                }
                return $next($request);
            }
        }
        return abort(403);
    }
}
