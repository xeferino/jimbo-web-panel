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
use App\Models\Setting;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function saleTicket(FormSaleRequest $request)
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
                        $status  = 'refused';
                        $reference_code = null;
                        $amout_jib = 0;
                        if($request->method_type == 'card') {
                            //id de la tarjeta a pagar
                            $cardUser = Card::find($request->method_id);
                            //cargo que se le aplica a tarjeta por la compra
                            $charge  = [
                                "amount" => $ticket->promotion->price*100,
                                "capture" => true,
                                "currency_code" => "USD",
                                "description" => $ticket->promotion->quantity.' Boltetos por '.Helper::amount($ticket->promotion->price),
                                "email" => $user->email,
                                "installments" => 0,
                                "source_id" => $cardUser->culqi_card_id
                            ];

                            $payment = PaymentController::payment(null, $charge);
                            $pay =  $payment->object ?? 'error';

                            $saleUpdate = Sale::find($sale->id);

                            if ($pay == 'charge') {
                                $reference_code = $payment->reference_code;
                                $status = 'approved';
                                $ticket->total = $ticket->total-$ticket->promotion->quantity;
                                $ticket->save();
                                $saleUpdate->status = $status;
                                $saleUpdate->number_culqi = $reference_code;
                                $saleUpdate->method = 'card';
                                $saleUpdate->save();
                                TicketUser::insert($tickets);

                                $payment_receipt = [
                                    'fullname'          => $saleUpdate->name,
                                    'date'              => $saleUpdate->created_at,
                                    'code_ticket'       => $ticket->serial,
                                    'tickets'           => $saleUpdate->TicketsUsers,
                                    'quantity'          => $ticket->promotion->quantity,
                                    'number_operation'  => $saleUpdate->number,
                                    'amount'            => Helper::amount($ticket->promotion->price),
                                    "description"       => 'Compra '.$ticket->promotion->quantity.' Boltetos por '.Helper::amount($ticket->promotion->price),
                                    'raffle'            => $ticket->raffle->title,
                                    'type'              => 'card'

                                ];
                                Mail::to($user->email)->send(new ReceiptPayment($payment_receipt));
                            }

                            $type = null;
                            $merchant_message = null;
                            if($pay != 'charge') {
                                $payment = json_decode($payment, true);
                                $type = $payment['type'];
                                $merchant_message = $payment['merchant_message'];
                            }

                            $data = [
                                'sale_id'        => $saleUpdate->id,
                                'user_id'        => $user->id,
                                "description"    => $ticket->promotion->quantity.' Boltetos por '.Helper::amount($ticket->promotion->price),
                                'payment_method' => 'Jib',
                                'total_paid'     => Helper::amount($ticket->promotion->price),
                                'response'       => ($status == 'approved') ? 'Su compra ha sido exitosa.' : 'Error: '.$type,
                                'code_response'  => ($status == 'approved') ? $reference_code : $merchant_message,
                                'status'         => $status,
                                'created_at'     => now(),
                                'updated_at'     => now()
                            ];
                            $PaymentHistory = PaymentController::paymentHistoryStore($data);
                        }elseif ($request->method_type == 'jib') {
                            # code...
                            $jib_unit = Setting::where('name', 'jib_unit_x_usd')->first();
                            $jib_usd = Setting::where('name', 'jib_usd')->first();

                            $amout_jib = ($ticket->promotion->price*$jib_unit->value)/$jib_usd->value;

                            $available_jib = $user->balance_jib-$amout_jib;

                            if (intval($user->balance_jib)<$amout_jib) {
                                return response()->json([
                                    'error'    => true,
                                    'message'  => 'Balance en jib '.$user->balance_jib.', es insuficiente, usted requiere de un saldo mayor o igual a '.$amout_jib.'.00 jib',
                                ], 422);
                            }
                            $saleUpdate = Sale::find($sale->id);
                            $reference_code = substr(sha1(time()), 0, 6);
                            $status = 'approved';
                            $ticket->total = $ticket->total-$ticket->promotion->quantity;
                            $saleUpdate->method = 'jib';
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
                                'amount'            => Helper::jib($amout_jib),
                                "description"       => 'Compra '.$ticket->promotion->quantity.' Boltetos por '.Helper::amount($ticket->promotion->price),
                                'raffle'            => $ticket->raffle->title,
                                'type'              => 'jib'
                            ];
                            Mail::to($user->email)->send(new ReceiptPayment($payment_receipt));

                            $data = [
                                'sale_id'        => $saleUpdate->id,
                                'user_id'        => $user->id,
                                "description"    => $ticket->promotion->quantity.' Boltetos por '.Helper::amount($ticket->promotion->price),
                                'payment_method' => 'Card',
                                'total_paid'     => Helper::jib($amout_jib),
                                'response'       => ($status == 'approved') ? 'Su compra ha sido exitosa.' : 'Error: Su compra no ha sido exitosa',
                                'code_response'  => ($status == 'approved') ? $reference_code : 'Error',
                                'status'         => $status,
                                'created_at'     => now(),
                                'updated_at'     => now()
                            ];
                            $PaymentHistory     = PaymentController::paymentHistoryStore($data);
                            $user->balance_jib  =  $available_jib;
                            $user->save();
                            BalanceController::store($data['description'], 'debit', $amout_jib, 'jib', $user->id);
                        }elseif ($request->method_type == 'cash') {
                            if (intval($user->balance_usd)<$ticket->promotion->price) {
                                return response()->json([
                                    'error'    => true,
                                    'message'  => 'Balance en usd '.$user->balance_usd.', es insuficiente',
                                ], 422);
                            }
                            $saleUpdate = Sale::find($sale->id);
                            $reference_code = substr(sha1(time()), 0, 6);
                            $status = 'approved';
                            $ticket->total = $ticket->total-$ticket->promotion->quantity;
                            $saleUpdate->method = 'cash';
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
                                'amount'            => Helper::jib($amout_jib),
                                "description"       => 'Compra '.$ticket->promotion->quantity.' Boltetos por '.Helper::amount($ticket->promotion->price),
                                'raffle'            => $ticket->raffle->title,
                                'type'              => 'Efectivo'
                            ];
                            Mail::to($user->email)->send(new ReceiptPayment($payment_receipt));

                            $data = [
                                'sale_id'        => $saleUpdate->id,
                                'user_id'        => $user->id,
                                "description"    => $ticket->promotion->quantity.' Boltetos por '.Helper::amount($ticket->promotion->price),
                                'payment_method' => 'Cash',
                                'total_paid'     => Helper::jib($amout_jib),
                                'response'       => ($status == 'approved') ? 'Su compra ha sido exitosa.' : 'Error: Su compra no ha sido exitosa',
                                'code_response'  => ($status == 'approved') ? $reference_code : 'Error',
                                'status'         => $status,
                                'created_at'     => now(),
                                'updated_at'     => now()
                            ];
                            $PaymentHistory     = PaymentController::paymentHistoryStore($data);
                            $user->balance_usd  =  intval($user->balance_usd)-$ticket->promotion->price;
                            $user->save();
                            BalanceController::store($data['description'], 'debit', $ticket->promotion->price, 'usd', $user->id);
                        }
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
                                'amount'            => Helper::amount($ticket->promotion->price),
                            ]
                        ], 200);
                    }
                }
            }
            return response()->json([
                'error'             => true,
                'message'           => 'El pago no se proceso con exito.',
                'culqi_response'    => $request->method_type == 'card' ? $merchant_message : null
            ], 422);
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
            $user = isset($data->other) && $data->other == 1 ? null : User::find($data->user_id);
            if(isset($data->other) && $data->other == 1) {
                if(!$user->hasRole('seller'))
                    $user->assignRole('seller');
            } else {
                if(!$user->hasRole('competitor'))
                    $user->assignRole('competitor');
            }
            $sale = new Sale();
            $fullnames        =   $user->names . ' ' . $user->surnames;
            $sale->name       =   $fullnames;
            $sale->dni        =   $user ? $user->dni :  $data->dni;
            $sale->phone      =   $user ? $user->phone :  $data->phone;
            $sale->email      =   $user ? $user->email :  $data->email;
            $sale->address    =   $user ? $user->address :  $data->address;
            $sale->country_id =   $data->country_id;
            $sale->amount     =   $ticket->promotion->price;
            $sale->number     =   time();
            $sale->quantity   =   $ticket->promotion->quantity;
            $sale->ticket_id  =   $ticket->id;
            $sale->seller_id  =   isset($data->other) && $data->other == 1 ? $data->seller_id : null;
            $sale->user_id    =   isset($data->other) && $data->other == 1 ? null : $data->user_id;
            $sale->raffle_id  =   $data->raffle_id;
            $sale->status     =   'pending';
            $sale->save();
            return $sale;
        }
        return $sale;
    }
}
