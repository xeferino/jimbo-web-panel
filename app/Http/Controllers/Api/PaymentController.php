<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PaymentHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Services\CulqiService as Culqi;
use App\Models\CardUser as Card;
use App\Models\PaymentMethod;


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
        $payments = PaymentHistory::where('user_id', $request->user)->get();

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
}
