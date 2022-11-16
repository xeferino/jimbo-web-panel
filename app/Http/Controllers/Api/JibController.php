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
use App\Models\CardUser as Card;
use App\Mail\ReceiptPayment;
use Illuminate\Support\Facades\Mail;
use Exception;
use App\Models\User;
use App\Helpers\Helper;
use App\Models\Setting;


class JibController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $jib_usd = SettingController::jib()['value']['jib_usd'];
            $jib_unit_x_usd = SettingController::jib()['value']['jib_unit_x_usd'];

            return response()->json(['jibs' => [
                /* [
                    'jib' => 10,
                    'usd' => (10/$jib_unit_x_usd)*$jib_usd // 1 usd
                ], */
                [
                    'jib' => 5000,
                    'usd' => (5000/$jib_unit_x_usd)*$jib_usd // 5 usd
                ],
                [
                    'jib' => 10000,
                    'usd' => (10000/$jib_unit_x_usd)*$jib_usd // 10 usd
                ],
                [
                    'jib' => 150000,
                    'usd' => (150000/$jib_unit_x_usd)*$jib_usd // 15 usd
                ],
                [
                    'jib' => 20000,
                    'usd' => (20000/$jib_unit_x_usd)*$jib_usd // 20 usd
                ],
                [
                    'jib' => 50000,
                    'usd' => (50000/$jib_unit_x_usd)*$jib_usd // 50 usd
                ]
            ]], 200);

        } catch (Exception $e) {
            return response()->json([
                'status'   => 400,
                'message' =>  $e->getMessage()
            ], 400);
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
