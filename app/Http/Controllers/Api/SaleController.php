<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\PaymentController;
use Illuminate\Http\Request;
use App\Http\Requests\Api\FormSaleRequest;
use App\Models\CardUser as Card;
use Illuminate\Support\Facades\DB;
use App\Mail\ReceiptPayment;
use Illuminate\Support\Facades\Mail;
use Exception;
use App\Models\Slider;
use App\Models\Ticket;
use App\Models\Sale;
use App\Models\TicketUser;
use App\Models\User;
use App\Helpers\Helper;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function saleTicketCard(FormSaleRequest $request)
    {
        try {
            DB::beginTransaction();
            $sale =  $this->saleOfTickets($request);
            if($sale) {
                $tickets = $this->generateTickets($request, $sale->id);
                if(count($tickets)>0){
                    $ticket = Ticket::where('id', $request->ticket_id)->where('raffle_id', $request->raffle_id)->first();
                    if($ticket) {
                        $user = isset($request->user_id) ? User::find($request->user_id) : null;
                        $cardUser = Card::find($request->card_id);
                        $expire = explode('/',$cardUser->date_expire);

                        //token de la tarjeta a validar para hacer la compra
                        $card = [
                            'card_number' => $cardUser->number,
                            'cvv' => $cardUser->code,
                            'expiration_month' => $expire[0],
                            'expiration_year' => $expire[1],
                            'email' => $user ? $user->email :  $request->email,
                            'metadata' => [
                                'fullname'  => $user->names. ' ' .$user->surnames,
                                'phone'     => $user->phone,
                                'dni'       => $user->dni,
                                'address'   => $user->address,
                                'address_city'   => $user->address_city
                            ]
                        ];

                        //cargo que se le aplica a tarjeta por la compra
                        $charge  = [
                            "amount" => $ticket->promotion->price*100,
                            "capture" => true,
                            "currency_code" => "USD",
                            "description" => $ticket->promotion->quantity.' Boltetos por '.Helper::amount($ticket->promotion->price),
                            "email" => "payment@jimbosorteos.com",
                            "installments" => 0,
                        ];

                        //$payment = PaymentController::payment($card, $charge);
                        //$pay =  $payment->object ?? '';

                        $saleUpdate = Sale::find($sale->id);
                        //$status  = 'refused';
                        $status  = 'approved';

                        /*if ($pay == 'charge') {
                            $status = 'approved';
                            $ticket->total = $ticket->total-$ticket->promotion->quantity;
                            $ticket->save();
                            $saleUpdate->status = $status;
                            $saleUpdate->save();
                            TicketUser::insert($tickets);
                            $payment_receipt = [
                                'fullname'          => $saleUpdate->name,
                                'date'              => $saleUpdate->created_at,
                                'code_ticket'       => $ticket->serial,
                                'tickets'           => $saleUpdate->TicketsUsers,
                                'quantity'          => $ticket->promotion->quantity,
                                'number_operation'  => $saleUpdate->number,
                                'amount'            => $ticket->promotion->price,
                                'raffle'            => $ticket->raffle->title
                            ];
                            Mail::to($user->email)->send(new ReceiptPayment($payment_receipt));
                        }*/

                        $type = null;
                        $merchant_message = null;
                        /*if($pay != 'charge') {
                            $payment = json_decode($payment, true);
                            $type = $payment['type'];
                            $merchant_message = $payment['merchant_message'];
                        }*/

                        $data = [
                            'sale_id'        => $saleUpdate->id,
                            'user_id'        => $user->id,
                            "description"    => $ticket->promotion->quantity.' Boltetos por '.Helper::amount($ticket->promotion->price),
                            'payment_method' => 'Card',
                            'total_paid'     => $ticket->promotion->price,
                            'response'       => ($status == 'approved') ? 'charge: successful payment Culqi platform' : 'Error: '.$type,
                            'code_response'  => ($status == 'approved') ? '200' : $merchant_message,
                            'status'         => $status,
                            'created_at'     => now(),
                            'updated_at'     => now()
                        ];
                        $PaymentHistory = PaymentController::paymentHistoryStore($data);
                    }
                    DB::commit();
                    if($status == 'approved') {
                        return response()->json([
                            'success' => true,
                            'message' => 'Pago procesado exitosamente.',
                            'details' => [
                                'fullname'          => $saleUpdate->name,
                                'date'              => $saleUpdate->created_at,
                                'code_ticket'       => $ticket->serial,
                                'tickets'           => $saleUpdate->TicketsUsers,
                                'quantity'          => $ticket->promotion->quantity,
                                'number_operation'  => $saleUpdate->number,
                                'amount'            => $ticket->promotion->price,
                            ]
                        ], 200);
                    }
                }
            }
            return response()->json([
                'error'             => true, 
                'message'           => 'El pago no se proceso con exito.',
                'culqi_response'    => $merchant_message
            ], 422);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'   => 500,
                'message' =>  $e->getMessage()
            ], 500);
        }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function saleTicketJib(FormSaleRequest $request)
    {
        try {
            DB::beginTransaction();
            $sale =  $this->saleOfTickets($request);
            if($sale) {
                $tickets = $this->generateTickets($request, $sale->id);
                if(count($tickets)>0){
                    $SaleTickets = TicketUser::insert($tickets);
                    if($SaleTickets){
                        $ticket = Ticket::where('id', $request->ticket_id)->where('raffle_id', $request->raffle_id)->first();
                        if($ticket) {
                            $ticket->total = $ticket->total-$ticket->promotion->quantity;
                            $ticket->save();
                            if($ticket->save()) {
                                $saleUpdate = Sale::find($sale->id);
                                $saleUpdate->status = 'approved';
                                $saleUpdate->save();
                                $user = isset($request->user_id) ? User::find($request->user_id) : null;
                                $cardUser = Card::find($request->card_id);
                                $expire = explode('/',$cardUser->date_expire);
                                $card = [
                                    //'card_number' => '4000020000000000',
                                    'card_number' => $cardUser->number,
                                    'cvv' => $cardUser->code,
                                    'expiration_month' => $expire[0],
                                    'expiration_year' => $expire[1],
                                    'email' => $user ? $user->email :  $request->email,
                                    'metadata' => [
                                        'fullname'  => $user ? $user->name :  $request->name,
                                        'phone'     => $user ? $user->dni :  $request->dni,
                                        'dni'       => $user ? $user->dni :  $request->dni,
                                        'address'   => $user ? $user->address :  $request->address,
                                    ]
                                ];


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

                                $PaymentHistory = payment::paymentHistoryStore($data);

                                $data = [
                                    'sale_id'        => $saleUpdate->id,
                                    'description'    => $ticket->promotion->name,
                                    'payment_method' => 'Card',
                                    'total_paid'     => $ticket->promotion->price,
                                    'response'       => 'Pago exitoso',
                                    'code_response'  => 200,
                                    'status'         => $saleUpdate->status
                                ];
                                $PaymentHistory = PaymentController::paymentHistoryStore($data);
                            }
                        }
                    }
                }
                DB::commit();
                return response()->json([$SaleTickets], 200);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'   => 500,
                'message' =>  $e->getMessage()
            ], 500);
        }
    }

    private function generateTickets($data, $sale_id) {
        $ticket = Ticket::where('id', $data->ticket_id)->where('raffle_id', $data->raffle_id)->first();
        $tickets = [];
        if ($ticket) {
            for ($i = 1; $i <= $ticket->promotion->quantity; $i++) {
                array_push($tickets, [
                    'serial'        =>  $ticket->id.$i.time(),
                    'ticket_id'     =>  $ticket->id,
                    'raffle_id'     =>  $ticket->raffle_id,
                    'user_id'       =>  isset($data->user_id) ? $data->user_id : null,
                    'sale_id'       =>  $sale_id,
                    'created_at'    =>  now(),
                    'updated_at'    =>  now(),
                ]);
            }
            return $tickets;
        }
        return $tickets;
    }

    private function saleOfTickets($data) {
        $ticket = Ticket::where('id', $data->ticket_id)->where('raffle_id', $data->raffle_id)->first();
        $sale = null;

        if ($ticket) {
            $user = isset($data->user_id) ? User::find($data->user_id) : null;
            $sale = new Sale();
            $sale->name       =   $user ? $user->name :  $data->name;
            $sale->dni        =   $user ? $user->dni :  $data->dni;
            $sale->phone      =   $user ? $user->phone :  $data->phone;
            $sale->email      =   $user ? $user->email :  $data->email;
            $sale->country_id =   $data->country_id;
            $sale->amount     =   $ticket->promotion->price;
            $sale->number     =   time();
            $sale->quantity   =   $ticket->promotion->quantity;
            $sale->ticket_id  =   $ticket->id;
            $sale->seller_id  =   isset($data->seller_id) ? $data->seller_id : null;
            $sale->user_id    =   isset($data->user_id) ? $data->user_id : null;
            $sale->raffle_id  =   $data->raffle_id;
            $sale->status     =   'pending';
            $sale->save();
            return $sale;
        }
        return $sale;
    }
}
