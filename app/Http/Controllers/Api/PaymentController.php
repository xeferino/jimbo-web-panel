<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\NotificationController;
use App\Models\PaymentHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Services\CulqiService as Culqi;
use App\Models\CardUser as Card;
use App\Models\PaymentMethod;
use App\Models\User;
use App\Http\Requests\Api\FormCashRequest;
use App\Helpers\Helper;
use App\Models\CashRequest;


class PaymentController extends Controller
{
    private $asset;
    private $data;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->asset = config('app.url').'/assets/images/methods/';
        $this->data = [];
    }

    public static function payment($card = null, $charge)
    {
        try{
            $culqi = new Culqi();
            return $culqi->charge($charge);
        } catch (Exception $e) {
            return response()->json(['message' =>  $e->getMessage()]);
        }
    }

    public static function paymentHistoryStore($data)
    {
        $payment = PaymentHistory::insert($data);
        return $payment;
    }

    public function paymentHistory(Request $request)
    {
        $payments = PaymentHistory::select(
            'sale_id',
            'user_id',
            'description',
            'payment_method',
            'total_paid',
            'response',
            'code_response',
            DB::raw('(CASE
                                WHEN status = "approved" THEN "Aprobado"
                                WHEN status = "refused" THEN "Rechazado"
                                ELSE "Otro"
                                END) AS status'),
            'created_at',
            'updated_at'
            )
            ->orderBy('created_at','DESC')
            ->where('user_id', $request->user)->get();

        return response()->json([
            'status'  => 200,
            'payment_histories' => $payments
        ], 200);
    }

    public function paymentDetail(Request $request)
    {
        $payment = PaymentHistory::where('user_id', $request->user_id)->where('id', $request->payment_id)->first();

        return response()->json([
            'status'  => 200,
            'payment' => $payment
        ], 200);
    }

    public function paymentMethod(Request $request)
    {
        try {
            $cards = [];
            foreach (Card::where('user_id', $request->user_id)->get() as $key => $value) {
                # code...
                array_push($cards, [
                    'id'    => $value->id,
                    'name'  => $value->number,
                    'icon'  => $this->asset.$value->icon,
                    'type'  => $value->type,
                    'valid' => $value->deleted_at == null ? true : false
                ]);
            }
            $methods = [];
            $PaymentMethods = PaymentMethod::select('id', 'name', 'type', 'valid', DB::raw("CONCAT('".$this->asset."',icon) AS icon"))->whereNull('deleted_at')->get();

            foreach ($PaymentMethods as $key => $value) {
                # code...
                array_push($methods, [
                    'id'    => $value->id,
                    'name'  => $value->name,
                    'icon'  => $value->icon,
                    'type'  => $value->type,
                    'valid' => $value->valid ? true : false
                ]);
            }

            return response()->json([
                'methods' => $methods,
                'cards' => $cards
            ], 200);

        } catch (Exception $e) {

            return response()->json([
                'status'   => 400,
                'message' =>  $e->getMessage()
            ], 400);
        }
    }

    public function cashRequest (FormCashRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = isset($request->user_id) ? User::find($request->user_id) : null;

            $amount = $request->amount;

            if ($amount>intval($user->balance_usd)) {
                return response()->json([
                    'error'    => true,
                    'message'  => 'Balance en usd '.Helper::amount($user->balance_usd).', es insuficiente.',
                ], 422);
            }

            $data = [
                "description_request"    => 'solicitud de retiro por '.Helper::amount($amount),
            ];


            $debit  = BalanceController::store($data['description_request'], 'debit', $amount, 'usd', $user->id);
            $notification = NotificationController::store('Has solicitado un retiro de efectivo', 'Solicitud de retiro '.Helper::amount($amount), $user->id);

            $cash = CashRequest::insert([
                'currency'          => 'usd',
                'amount'            =>  $amount,
                'date'              =>  date('Y-m-d'),
                'hour'              =>  date('H:i:s'),
                'reference'         => time(),
                'description'       => $data['description_request'],
                'status'            => 'created',
                'user_id'           => $user->id,
                'account_user_id'   => $request->account_user_id
            ]);
            $user->balance_usd = $user->balance_usd-$amount;
            $user->save();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'La solitud de retiro ha sido procesado exitosamente.',
                'details' => [
                    'fullname'          => $user->names .' '. $user->surnames,
                    'date'              => now(),
                    'amount'            => Helper::amount($amount),
                ]
            ], 200);

            return response()->json([
                'error'             => true,
                'message'           => 'La solitud de retiro no se proceso con exito.',
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
