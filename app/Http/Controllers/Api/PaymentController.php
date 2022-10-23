<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use App\Services\CulqiService;


class PaymentController extends Controller
{
    public function payment(Request $request)
    {
        try{
            //card token
            $card = [
                //'card_number' => '4000020000000000',
                //'card_number' => '4111111111111111 ',
                'card_number' => '4000040000000008',
                'cvv' => '295',
                'expiration_month' => '03',
                'expiration_year' => '25',
                'email' => 'josegregoriolozadae@gmail.com',
                'metadata' => [
                    'fullname'  => 'Jose Lozada',
                    'phone'     => '4149585692',
                    'dni'       => '2073816',
                ]
            ];

            //charge in card client payment
            $charge  = [
                "amount" => 10*100,
                "capture" => true,
                "currency_code" => "PEN",
                "description" => "Venta de prueba",
                "email" => "test@culqi.com",
                "installments" => 0,
                "antifraud_details" => [
                    "address" => "Av. Lima 123",
                    "address_city" => "LIMA",
                    "country_code" => "PE",
                    "first_name" => "Will",
                    "last_name" => "Muro",
                    "phone_number" => "9889678986",
                ],
            ];

            $culqi = new CulqiService($card);
            return response()->json(['payment'   => $culqi->charge($charge)]);
        } catch (Exception $e) {
            return response()->json(['message' =>  $e->getMessage()]);
        }
    }
}
