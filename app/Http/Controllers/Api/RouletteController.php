<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Slider;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Requests\Api\FormRechargeRequest;
use App\Http\Requests\Api\FormExchangeRequest;
use App\Http\Controllers\Api\BalanceController;
use App\Models\CardUser as Card;
use App\Mail\ReceiptPayment;
use Illuminate\Support\Facades\Mail;
use Exception;
use App\Models\User;
use App\Helpers\Helper;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

class RouletteController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            return response()->json(['apuestas' => [
                [
                    'jib' => Helper::amountJib(0.10),
                    'usd' => 0.10
                ],
                [
                    'jib' => Helper::amountJib(0.25),
                    'usd' => 0.25
                ],
                [
                    'jib' => Helper::amountJib(0.50),
                    'usd' => 0.50
                ],
                [
                    'jib' => Helper::amountJib(1),
                    'usd' => 1
                ],
                [
                    'jib' => Helper::amountJib(5),
                    'usd' => 5
                ],
                [
                    'jib' => Helper::amountJib(10),
                    'usd' => 10
                ],
            ]], 200);

        } catch (Exception $e) {
            return response()->json([
                'status'   => 400,
                'message' =>  $e->getMessage()
            ], 400);
        }
    }

    public function wager(Request $request)
    {
        $balance = BalanceController::getBalance();
        $number = [1, 2, 3, 5, 10, 20, 'X2', 'X5', '1000 JIB', '5000 JIB'];
        $roulette = in_array($request->result, $number);
        $amount = 0;
        $type = null;

        $multiplier = $request->multiplier ? $request->multiplier : 1;

        if ($roulette && $request->result == 'X2') {
            return response()->json([
                'success' => true,
                'title'   => 'Aumento de probabilidad X2',
                'message' => 'Has ganado una nueva oportunidad de girar la ruleta y multiplicar tus ganancias.',
                'balance_usd' => $balance['balance_usd'],
                'balance_jib' => $balance['balance_jib']
            ], 200);
        }else if ($roulette && $request->result == 'X5') {
            return response()->json([
                'success' => true,
                'title'   => 'Aumento de probabilidad X5',
                'message' => 'Has ganado una nueva oportunidad de girar la ruleta y multiplicar tus ganancias.',
                'balance_usd' => $balance['balance_usd'],
                'balance_jib' => $balance['balance_jib']
            ], 200);
        } elseif ($roulette && $request->result == 1) {
            if ($request->bet[0] > 0) {
                $amount =  ((1 * $multiplier) *  $request->bet[0] ) + $request->bet[0];
            }
        } else if ($roulette && $request->result == 2) {
            if ($request->bet[1] > 0) {
                $amount =  ((2 * $multiplier) *  $request->bet[1] ) + $request->bet[1];
            }
        }else if ($roulette && $request->result == 3) {
            if ($request->bet[2] > 0) {
                $amount =  ((3 * $multiplier) *  $request->bet[2] ) + $request->bet[2];
            }
        } else if ($roulette && $request->result == 5) {
            if ($request->bet[3] > 0) {
                $amount =  ((5 * $multiplier) *  $request->bet[3] ) + $request->bet[3];
            }
        } else if ($roulette && $request->result == 10) {
            if ($request->bet[4] > 0) {
                $amount =  ((10 * $multiplier) *  $request->bet[4] ) + $request->bet[4];
            }
        } else if ($roulette && $request->result == 20) {
            if ($request->bet[5] > 0) {
                $amount =  ((20 * $multiplier) *  $request->bet[5] ) + $request->bet[5];
            }
        }else if ($roulette && $request->result == '1000 JIB') {
            $type =  '1000JIB';
        }else if ($roulette && $request->result == '5000 JIB') {
            $type =  '5000JIB';
        }

        $prize =  $amount;
        if ($type == '1000JIB') {
            $jib_usd = Setting::where('name', 'jib_usd')->first();
            $prize = $jib_usd->value*1000;
        } else if($type == '5000JIB') {
            $jib_usd = Setting::where('name', 'jib_usd')->first();
            $prize = $jib_usd->value*5000;
        }
        $debit = BalanceController::store('Apuesta en ruleta por un monto en usd '.Helper::amount($request->strake), 'debit', $request->strake, 'usd', Auth::user()->id, 1);

        if ($prize > 0) {
            $credit = BalanceController::store('Has ganado en la ruleta un monto en usd '.Helper::amount($prize), 'credit', $prize, 'usd', Auth::user()->id, 1);
            return response()->json([
                'success' => true,
                'title'   => 'GANO '.Helper::amount($prize),
                'message' => 'Felicidades! has ganado, estas de suerte',
                'balance_usd' => $credit['balance_usd'],
                'balance_jib' => $credit['balance_jib']
            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'title'   => 'PERDIO '.Helper::amount(($request->strake)),
                'message' => 'Vuelva a intentar hacer una nueva apuesta, suerte ',
                'balance_usd' => $debit['balance_usd'],
                'balance_jib' => $debit['balance_jib']
            ], 200);
        }
    }

    public function recharge(FormRechargeRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = isset($request->user_id) ? User::find($request->user_id) : null;
            $status  = 'refused';
            $reference_code = null;
            //id de la tarjeta a pagar
            $cardUser = Card::find($request->method_id);
            //cargo que se le aplica a tarjeta por la compra

            $jib_unit = Setting::where('name', 'jib_unit_x_usd')->first();
            $jib_usd = Setting::where('name', 'jib_usd')->first();

            $amout = ($request->amout_jib*$jib_usd->value);

            $charge  = [
                "amount" => $amout*100,
                "capture" => true,
                "currency_code" => "USD",
                "description" => 'Recarga de jib '.$request->amout_jib,
                "email" => $user->email,
                "installments" => 0,
                "source_id" => $cardUser->culqi_card_id
            ];

            $payment = PaymentController::payment(null, $charge);
            $pay =  $payment->object ?? 'error';

            if ($pay == 'charge') {
                $reference_code = $payment->reference_code;
                $status = 'approved';
            }

            $type = null;
            $merchant_message = null;
            if($pay != 'charge') {
                $payment = json_decode($payment, true);
                $type = $payment['type'];
                $merchant_message = $payment['merchant_message'];
            }

            $data = [
                'sale_id'        => null,
                'user_id'        => $user->id,
                "description"    => 'Recarga de jib '.$request->amout_jib,
                'payment_method' => 'Card',
                'total_paid'     => Helper::amount($amout),
                'response'       => ($status == 'approved') ? 'Su recarga ha sido exitosa.' : 'Error: '.$type,
                'code_response'  => ($status == 'approved') ? $reference_code : $merchant_message,
                'status'         => $status,
                'created_at'     => now(),
                'updated_at'     => now()
            ];
            $PaymentHistory = PaymentController::paymentHistoryStore($data);
            $user->balance_jib  =  $user->balance_jib + $request->amout_jib;
            $user->save();
            BalanceController::store($data['description'], 'recharge', $request->amout_jib, 'jib', $user->id);
            $notification = NotificationController::store('Nueva Recarga!', 'has recibo '.$request->amout_jib.' jibs en tu balance', $user->id);

            DB::commit();
            if($status == 'approved') {
                return response()->json([
                    'success' => true,
                    'message' => 'La recarga y/o pago procesado exitosamente.',
                    'details' => [
                        'fullname'          => $user->names .' '. $user->surnames,
                        'date'              => date('d/m/Y H:i:s'),
                        'quantity'          => $request->amout_jib,
                        'number_operation'  => $data['code_response'],
                        'amount'            => Helper::amount($amout),
                        'jib'               => Helper::jib($request->amout_jib),
                    ]
                ], 200);
            }
            return response()->json([
                'error'             => true,
                'message'           => 'La recarga y/o pago no se proceso con exito.',
                'culqi_response'    => $merchant_message
            ], 422);
        }catch (Exception $e) {
                DB::rollBack();
                return response()->json([
                    'status'   => 500,
                    'message' =>  $e->getMessage()
                ], 500);
        }
    }

    public function exchange(FormExchangeRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = isset($request->user_id) ? User::find($request->user_id) : null;

            $jib_unit = Setting::where('name', 'jib_unit_x_usd')->first();
            $jib_usd = Setting::where('name', 'jib_usd')->first();

            $amout = ($request->amout_jib*$jib_usd->value);

            if ($user->balance_jib<$request->amout_jib) {
                return response()->json([
                    'error'    => true,
                    'message'  => 'Balance en jib '.$user->balance_jib.', es insuficiente.',
                ], 422);
            }

            $data = [
                "description_jib"    => 'canje de jib '.$request->amout_jib. ' por '.Helper::amount($amout),
                "description_usd"    => 'credito de '.$amout
            ];


            $debit  = BalanceController::store($data['description_jib'], 'debit', $request->amout_jib, 'jib', $user->id);
            $credit = BalanceController::store($data['description_usd'], 'exchange', $amout, 'usd', $user->id);

            $user->balance_jib = $user->balance_jib-$request->amout_jib;
            $user->balance_usd = $user->balance_usd+$amout;
            $notification = NotificationController::store('Nuevo Cambio!', 'has canjeado '.$request->amout_jib.' jibs por efectivo '.Helper::amount($amout), $user->id);

            if ($user->save()){
                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'El cambio ha sido procesado exitosamente.',
                    'details' => [
                        'fullname'          => $user->names .' '. $user->surnames,
                        'date'              => date('d/m/Y H:i:s'),
                        'quantity'          => $request->amout_jib,
                        'amount'            => Helper::amount($amout),
                    ]
                ], 200);
            }

            return response()->json([
                'error'             => true,
                'message'           => 'El cambio no se proceso con exito.',
            ], 422);
        }catch (Exception $e) {
                DB::rollBack();
                return response()->json([
                    'status'   => 500,
                    'message' =>  $e->getMessage()
                ], 500);
        }
    }
}
