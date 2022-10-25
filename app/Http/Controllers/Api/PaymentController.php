<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PaymentHistory;
use Illuminate\Http\Request;
use Exception;
use App\Services\CulqiService as Culqi;


class PaymentController extends Controller
{
    public static function payment($card, $charge)
    {
        try{
            $culqi = new Culqi($card);
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
}
