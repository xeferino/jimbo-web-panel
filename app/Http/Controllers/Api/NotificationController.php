<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\FormNotificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Models\Notification;

class NotificationController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            if( $request->clean == 1){
                $notification = Notification::where('show', 0)->pluck('id')->toArray();
                $notification = Notification::whereIn('id', $notification)->update( ['show' => 1]);
            }
            $notifications = Notification::where('user_id', $request->user)->where('show', 0)->orderBy('created_at','DESC')->get();

            return response()->json([
                'status'  => 200,
                'notifications'   =>  $notifications
            ], 200);
        }catch (Exception $e) {
            return response()->json([
                'status'   => 500,
                'message' =>  $e->getMessage()
            ]);
        }
    }

     /**
     * Display a single of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        try {
            $account = Notification::findOrFail($request->account);
            //$account = Notification::where('id', $request->account)->first();

            return response()->json([
                'status'  => 200,
                'account'   =>  $account
            ], 200);
        }catch (Exception $e) {
            return response()->json([
                'status'   => 500,
                'message' =>  $e->getMessage()
            ]);
        }
    }
}
