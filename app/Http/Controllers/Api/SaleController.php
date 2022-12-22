<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\BalanceController;
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
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

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
                            if ($ticket->promotion->price<5) {
                                return response()->json([
                                    'error'    => true,
                                    'message'  => 'Para realizar una compra con tu tarjeta, el monto debe ser mayor o igual '. Helper::amount(5)
                                ], 422);
                            }
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
                                'response'       => ($status == 'approved') ? 'Su pago ha sido procesado exitosamente.' : 'Error: '.$type,
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

                            if ($user->balance_jib<$amout_jib) {
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

                            $data = [
                                'sale_id'        => $saleUpdate->id,
                                'user_id'        => $user->id,
                                "description"    => $ticket->promotion->quantity.' Boltetos por '.Helper::amount($ticket->promotion->price),
                                'payment_method' => 'Card',
                                'total_paid'     => Helper::jib($amout_jib),
                                'response'       => ($status == 'approved') ? 'Su pago ha sido procesado exitosamente.' : 'Error: Su pago no ha sido procesado exitosamente.',
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
                            if ($user->balance_usd<$ticket->promotion->price) {
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

                            $data = [
                                'sale_id'        => $saleUpdate->id,
                                'user_id'        => $user->id,
                                "description"    => $ticket->promotion->quantity.' Boltetos por '.Helper::amount($ticket->promotion->price),
                                'payment_method' => 'Cash',
                                'total_paid'     => Helper::jib($amout_jib),
                                'response'       => ($status == 'approved') ? 'Su pago ha sido procesado exitosamente.' : 'Error: Su pago no ha sido procesado exitosamente',
                                'code_response'  => ($status == 'approved') ? $reference_code : 'Error',
                                'status'         => $status,
                                'created_at'     => now(),
                                'updated_at'     => now()
                            ];
                            $PaymentHistory     = PaymentController::paymentHistoryStore($data);
                            $user->balance_usd  =  $user->balance_usd-$ticket->promotion->price;
                            $user->save();
                            BalanceController::store($data['description'], 'debit', $ticket->promotion->price, 'usd', $user->id);
                        }
                    }
                    DB::commit();
                    if($status == 'approved') {
                        $operation = $request->operation;
                        $seller = null;
                        $buyer = null;
                        if($user->type == 1) {
                            if($operation == 1){
                                $notification = NotificationController::store('Nueva Compra!', $ticket->promotion->quantity.' Boltetos por '.Helper::amount($ticket->promotion->price), $user->id);
                                $buyer = $saleUpdate->Buyer->names. ' ' .$saleUpdate->Buyer->surnames;
                                $this->receipt($saleUpdate->id, $user->email, 'buyer');
                            }else {
                                $seller = $saleUpdate->Seller->names. ' ' .$saleUpdate->Seller->surnames;
                                $buyer = $saleUpdate->name;
                                $this->receipt($saleUpdate->id, $user->email, 'seller');
                                $notification = NotificationController::store('Nueva Venta!', $ticket->promotion->quantity.' Boltetos por '.Helper::amount($ticket->promotion->price), $user->id);
                                $this->receipt($saleUpdate->id, $saleUpdate->email, 'buyer');
                            }
                        } elseif ($user->type == 2) {
                            $seller = $saleUpdate->Seller->names. ' ' .$saleUpdate->Seller->surnames;
                            $buyer = $saleUpdate->name;
                            $this->receipt($saleUpdate->id, $user->email, 'seller');
                            $notification = NotificationController::store('Nueva Venta!', $ticket->promotion->quantity.' Boltetos por '.Helper::amount($ticket->promotion->price), $user->id);
                            $this->receipt($saleUpdate->id, $saleUpdate->email, 'buyer');
                        }

                        $receipt_ope = $operation == 1 ? 'shopping' : 'sale';
                        $receipt_ope_user = $operation == 1 ? $saleUpdate->user_id : $saleUpdate->seller_id;
                        return response()->json([
                            'success' => true,
                            'message' => 'Pago procesado exitosamente.',
                            'details' => [
                                'fullname'          => $saleUpdate->name,
                                'buyer'             => $buyer,
                                'seller'            => $seller,
                                'date'              =>  Carbon::parse($saleUpdate->created_at)->format('d/m/Y H:i:s'),
                                'code_ticket'       => $ticket->serial,
                                'tickets'           => $saleUpdate->TicketsUsers,
                                'quantity'          => $ticket->promotion->quantity,
                                'number_operation'  => $saleUpdate->number,
                                'amount'            => Helper::amount($ticket->promotion->price),
                                'operation'         => $request->operation,
                                //'url_receipt'       => route('receipt', ['operation' => $receipt_ope, 'id' => $saleUpdate->id, 'user' => $receipt_ope_user])
                                'url_receipt'       => route('receipt', ['id' => encrypt($saleUpdate->id)])
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
        $user = User::find($data->user_id);

        $tickets = [];
        if ($ticket) {
            for ($i = 1; $i <= $ticket->promotion->quantity; $i++) {
                array_push($tickets, [
                    'serial'        =>  substr(sha1($ticket->id.$i.time()), 0, 8),
                    'ticket_id'     =>  $ticket->id,
                    'raffle_id'     =>  $ticket->raffle_id,
                    'user_id'       =>  $data->operation == 1 ? $user->id : null,
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
            $user = User::find($data->user_id);
            $sale = new Sale();
            $fullnames        =   $data->operation == 1 ? $user->names . ' ' . $user->surnames : $data->name;
            $sale->name       =   $fullnames;
            $sale->dni        =   $data->operation == 1 ? $user->dni :  $data->dni;
            $sale->phone      =   $data->operation == 1 ? $user->phone :  $data->phone;
            $sale->email      =   $data->operation == 1 ? $user->email :  $data->email;
            $sale->address    =   $data->operation == 1 ? $user->address :  $data->address;
            $sale->country_id =   $data->country_id;
            $sale->amount     =   $ticket->promotion->price;
            $sale->number     =   time();
            $sale->quantity   =   $ticket->promotion->quantity;
            $sale->ticket_id  =   $ticket->id;
            $sale->seller_id  =   $data->operation == 1 ? null: $user->id;
            $sale->user_id    =   $data->operation == 1 ? $user->id :null;
            $sale->raffle_id  =   $data->raffle_id;
            $sale->status     =   'pending';
            $sale->save();
            return $sale;
        }
        return $sale;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $sales = Sale::where('seller_id', $request->user)->where('status', 'approved')->orderBy('created_at','DESC')->get();

            $data = [];

            foreach ($sales as $key => $value) {
                # code...
               array_push($data, [
                   "id" => $value->id,
                   "name" =>  $value->name,
                   "dni" =>  $value->dni,
                   "phone" =>  $value->phone,
                   "email" =>  $value->email,
                   "address" =>  $value->address,
                   "country_id" =>  $value->country_id,
                   "amount" =>  $value->amount,
                   "number" =>  $value->number,
                   "number_culqi" =>  $value->number_culqi,
                   "quantity" =>  $value->quantity,
                   "ticket_id" =>  $value->ticket_id,
                   "seller_id" =>  $value->seller_id,
                   "user_id" =>  $value->user_id,
                   "raffle_id" =>  $value->raffle_id,
                   "status" =>  $value->status,
                   "method" =>  $value->method,
                   "created_at" => $value->created_at->format('d/m/Y H:i:s')
               ]);
            }
            return response()->json([
                'status'  => 200,
                'sales'   =>  $data
            ], 200);
        }catch (Exception $e) {
            return response()->json([
                'status'   => 500,
                'message' =>  $e->getMessage()
            ]);
        }
    }

    /**
     * Display a single of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        try {
            $sale = Sale::findOrFail($request->sale);
            $sale = [
                'raffle' => [
                    'title' => $sale->Raffle->title,
                    'first_prize'  => Helper::amount($sale->Raffle->cash_to_draw),
                    'status' => $sale->Raffle->active == 1 ? 'Activo' : 'Inactivo',
                    'finish' => $sale->Raffle->finish == 1 ? 'Finalizado' : 'Abierto',
                    'code_ticket' => $sale->Ticket->serial,
                    'tickets' => $sale->TicketsUsers,
                    'date_start' => $sale->Raffle->date_end->format('d/m/y'),
                    'date_end' => $sale->Raffle->date_end->format('d/m/y'),
                    'date_release' => $sale->Raffle->date_release->format('d/m/y'),
                ],
                'quantity' => $sale->quantity,
                'amount' => $sale->amount,
                'number_operation' => $sale->number,
                'date'  => $sale->created_at->format('d/m/y'),
                'hour'  => $sale->created_at->format('H:i:s'),
                'status' => $sale->status == 'approved' ? 'Aprodada' : 'Rechazada'
            ];

            return response()->json([
                'status'   => 200,
                'sale' => $sale
            ], 200);
        }catch (Exception $e) {
            return response()->json([
                'status'  => 500,
                'message' =>  $e->getMessage()
            ]);
        }
    }


    /**
     * Display a single of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function topSellers(Request $request)
    {
        try {
            $level_single_junior  = Setting::where('name', 'level_single_junior')->first();
            $level_single_middle  = Setting::where('name', 'level_single_middle')->first();
            $level_single_master  = Setting::where('name', 'level_single_master')->first();

            $top = Sale::select(
                DB::raw("CONCAT(users.names,' ',users.surnames) AS fullnames"),
                DB::raw('SUM(sales.amount) as amount'),
                DB::raw('(CASE
                                WHEN levels.name = "classic" and SUM(sales.amount)>=500 THEN "Clasico"
                                WHEN levels.name = "junior" and SUM(sales.amount)>='.$level_single_junior->value.' THEN "Junior"
                                WHEN levels.name = "middle" and SUM(sales.amount)>='.$level_single_middle->value.' THEN "Semi Senior"
                                WHEN levels.name = "master" and SUM(sales.amount)>='.$level_single_master->value.' THEN "Senior"
                                ELSE "Usuario"
                                END) AS level'),
                'users.image'
                )
                ->join('users', 'users.id', '=', 'sales.seller_id')
                ->leftJoin('level_users', 'level_users.seller_id', '=', 'sales.seller_id')
                ->leftJoin('levels', 'levels.id', '=', 'level_users.level_id')
                ->groupBy('sales.seller_id')
                ->whereNotNull('sales.seller_id')
                ->whereNull('sales.user_id')
                ->offset(0)->limit(10)
                ->orderBy('sales.id','DESC')
                ->get();

            $data = [];
            $i = 1;
            foreach ($top as $key => $value) {

               array_push($data, [
                'id'            => $i++,
                'fullnames'     => $value->fullnames,
                'amount'        => Helper::amount($value->amount),
                'level'         => $value->level,
                'image'         => $value->image != 'avatar.svg' ? config('app.url').'/assets/images/sellers/'.$value->Seller->image : config('app.url').'/assets/images/avatar.svg',
               ]);
            }
            return response()->json([
                'sellers' => $data,
                'status'   => 200
            ], 200);
        }catch (Exception $e) {
            return response()->json([
                'status'  => 500,
                'message' =>  $e->getMessage()
            ]);
        }
    }

    /**
     * Display a single graphics of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function graphics(Request $request)
    {
        try {
            $jib = User::whereHas("roles", function ($q) {
                $q->whereIn('name', ['seller']);
            })
            ->join('sales', 'sales.seller_id', '=', 'users.id' )
            ->whereNull('users.deleted_at')->where('users.active', 1)
            ->whereMonth('sales.created_at', date('m'))
            ->where('sales.status', 'approved')
            ->where('sales.method', 'jib')
            ->where('sales.seller_id', $request->user)
            ->count();

            $card = User::whereHas("roles", function ($q) {
                $q->whereIn('name', ['seller']);
            })
            ->join('sales', 'sales.seller_id', '=', 'users.id' )
            ->whereNull('users.deleted_at')->where('users.active', 1)
            ->whereMonth('sales.created_at', date('m'))
            ->where('sales.status', 'approved')
            ->where('sales.method', 'card')
            ->where('sales.seller_id', $request->user)
            ->count();

            $labels  = ['Jib', 'Tarjeta', 'Plin', 'Yape'];
            $data   = [$jib, $card, 0, 0];

            return response()->json([
                'grafics' => [
                    'sales' => [
                        'labels' => $labels,
                        'data'   => $data,
                    ]
                ],
                'status'   => 200
            ], 200);

        }catch (Exception $e) {
            return response()->json([
                'status'  => 500,
                'message' =>  $e->getMessage()
            ]);
        }
    }

    /**
     * Display a single graphics of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private function receipt($id, $email, $type = null)
    {
        try {
            //code...
            $sale = Sale::findOrFail($id);
            $operation = null;
            if($sale->user_id > 0 ){
                $operation = 'shopping';
            }elseif($sale->seller_id>0){
                $operation = 'sale';
            }

            $data = [];
            $seller = null;
            $buyer = null;
            $jib_unit = Setting::where('name', 'jib_unit_x_usd')->first();
            $jib_usd = Setting::where('name', 'jib_usd')->first();
            $amout_jib = null;

            if($operation == 'shopping'){
                if($sale){
                    $buyer = $sale->Buyer->names. ' ' .$sale->Buyer->surnames;
                    $amout_jib = ($sale->ticket->promotion->price*$jib_unit->value)/$jib_usd->value;

                }
            }else {
                if($sale) {
                    $seller = $sale->Seller->names. ' ' .$sale->Seller->surnames;
                    $buyer = $sale->name;
                    $amout_jib = ($sale->ticket->promotion->price*$jib_unit->value)/$jib_usd->value;
                }
            }

            $data = [
                'sale' => $sale,
                'type' => $operation == 'shopping' ? 'Compra' : 'Venta',
                'buyer' => $buyer,
                'seller' => $seller,
                'operation' => $operation,
                'amout_jib' => $amout_jib,
                'receipt'   => $type
            ];

            $pdf = Pdf::loadView('panel.sales.receipt', $data);
            $output = $pdf->output();
            Mail::to($email)->send(new ReceiptPayment([
                'pdf' => $output,
                'number' => str_pad($sale->id,6,"0",STR_PAD_LEFT),
                'type' => $operation == 'shopping' ? 'Compra' : 'Venta',
                'sale' => $sale,
                'operation' => $type,
                'buyer' => $buyer,
                'seller' => $seller,
            ]));
            return;
        } catch (\Throwable $th) {
            abort(400);
        }
    }
}
