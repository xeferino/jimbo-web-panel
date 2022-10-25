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
            $balance = DB::table('balance_histories')->select(
                'balance_histories.id',
                'balance_histories.reference',
                'balance_histories.description',
                'balance_histories.type',
                'balance_histories.currency',
                'balance_histories.balance',
                'balance_histories.date',
                'balance_histories.hour',
                )
                ->join('users', 'users.id', '=', 'balance_histories.user_id')
                ->where('users.id', $request->user)
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
    public static function store($description, $type, $amount, $currency, $user_id)
    {
        try {

            $data = [
                'reference'     => $user_id.time(),
                'description'   => $description,
                'type'          => $type,
                'balance'       => $amount,
                'currency'      => $currency,
                'date'          => date('Y-m-d'),
                'hour'          => date('H:i:s'),
                'user_id'       => $user_id,
                'created_at'    => now(),
                'updated_at'    => now()
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
