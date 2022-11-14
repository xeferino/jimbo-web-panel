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
            $notifications = Notification::where('user_id', $request->user)
            ->where('show', 0)
            ->orWhere('user_id', null)
            ->orderBy('created_at','DESC')->get();

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
     * store the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public static function store($title, $description, $user_id = null)
    {
        try {
            $data = [
                'title'         => $title,
                'description'   => $description,
                'user_id'       => $user_id,
                'created_at'    => now(),
            ];

            $notification = Notification::insert($data);
            if ($notification)
                return true;
        } catch (Exception $e) {
            return response()->json([
                'status'   => 500,
                'message' =>  $e->getMessage()
            ], 500);
        }
    }
}
