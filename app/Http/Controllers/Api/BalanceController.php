<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Models\BalanceHistory;
use App\Models\User;


class BalanceController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function balance(Request $request)
    {
        try {
            $balance = BalanceHistory::select(
                'id',
                'reference',
                'description',
                'type',
                'balance',
                'date',
                'hour',
                )
                ->join('users', 'users.id', '=', 'balance_histories.user_id')
                ->where('users.id', $request->user_id)
                ->get();

            return response()->json(['balance' => $balance], 200);

        } catch (Exception $e) {

            return response()->json([
                'status'   => 500,
                'message' =>  $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public static function store($description, $type, $amount, $user_id)
    {
        try {

            $data = [
                'reference'     => $user_id.time(),
                'description'   => $description,
                'type'          => $type,
                'balance'       => $amount,
                'date'          => date('Y-m-d'),
                'hour'          => date('H:i:s'),
                'user_id'       => $user_id,
            ];

            $balanceHitory = BalanceHistory::insert($data);

            if ($balanceHitory) {
                $user               =  User::find($data['user_id']);
                $user->balance_jib  =  $data['balance'];
                $user->save();
                return true;
            }

        } catch (Exception $e) {
            return response()->json([
                'status'   => 500,
                'message' =>  $e->getMessage()
            ], 500);
        }
    }
}
