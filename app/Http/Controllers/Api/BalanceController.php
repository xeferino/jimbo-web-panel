<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Models\BalanceHistory;
use App\Models\User;
use Illuminate\Support\Carbon;

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
            $user = User::find($request->user);
            $balances = DB::table('balance_histories')
                ->select(
                    'balance_histories.id',
                    'balance_histories.reference',
                    'balance_histories.description',
                    'balance_histories.type',
                    'balance_histories.currency',
                    'balance_histories.balance',
                    'balance_histories.date',
                    'balance_histories.hour',
                    'balance_histories.created_at'
                )
                ->join('users', 'users.id', '=', 'balance_histories.user_id')
                ->where('users.id', $request->user)
                ->orderBy('balance_histories.date','DESC')
                ->orderBy('balance_histories.hour','DESC')
                ->get();

            $data = [];

            foreach ($balances as $key => $value) {
                # code...
               array_push($data, [
                   "id" => $value->id,
                   "reference" =>  $value->reference,
                   "description" =>  $value->description,
                   "type" =>  $value->type,
                   "currency" =>  $value->currency,
                   "balance" =>  $value->balance,
                   "date" =>   Carbon::parse( $value->date)->format('d/m/Y'),
                   "hour" =>  Carbon::parse( $value->hour)->format('H:i:s'),
                   "created_at" => Carbon::parse( $value->created_at)->format('d/m/Y H:i:s')
               ]);
            }
            return response()->json([
                'balances'      => $data,
                'balance_jib'   => $user->balance_jib,
                'balance_usd'   => $user->balance_usd
            ], 200);

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
            $operation = null;
            if($type == 'recharge') {
                $operation = $type;
            } elseif ($type == 'exchange') {
                $operation = $type;
            } elseif ($type == 'request') {
                $operation = $type;
            } elseif ($type == 'credit' && $currency == 'jib'){
                $operation = 'bonus';
            }

            $data = [
                'reference'     => $user_id.time(),
                'description'   => $description,
                'type'          => ($type == 'recharge' or $type == 'exchange' or $type == 'request' or $type == 'credit') ? 'credit' : 'debit',
                'operation'     => $operation,
                'balance'       => $amount,
                'currency'      => $currency,
                'date'          => date('Y-m-d'),
                'hour'          => date('H:i:s'),
                'user_id'       => $user_id,
                'created_at'    => now(),
                'updated_at'    => now()
            ];

            $balanceHitory = BalanceHistory::insert($data);

            if ($balanceHitory && $type == 'credit' && $currency == 'jib') {
                $user               =  User::find($data['user_id']);
                $user->balance_jib  =  $user->balance_jib+$data['balance'];
                $user->save();
                return true;
            }
            if ($balanceHitory)
                return true;
        } catch (Exception $e) {
            return response()->json([
                'status'   => 500,
                'message' =>  $e->getMessage()
            ], 500);
        }
    }
}
