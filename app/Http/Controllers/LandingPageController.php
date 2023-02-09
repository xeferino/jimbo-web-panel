<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Sale;
use App\Models\CashRequest;
use App\Helpers\Helper;
use App\Models\Promotion;
use App\Models\Raffle;
use App\Models\Setting;
use App\Models\Ticket;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\BalanceController;
use App\Http\Requests\Api\FormSaleRequest;
use App\Models\CardUser as Card;
use App\Mail\ReceiptPayment;
use Illuminate\Support\Facades\Mail;
use Exception;
use App\Models\Slider;
use App\Models\TicketUser;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
class LandingPageController extends Controller
{
    private $asset;

    public function __construct()
    {
        $this->asset = config('app.url').'/assets/images/raffles/';
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function home(Request $request)
    {
        $raffles = Raffle::select(
            'raffles.id',
            'raffles.title',
            'raffles.description',
            'raffles.cash_to_draw',
            'raffles.date_start',
            'raffles.date_end',
            'raffles.date_release',
            DB::raw("TIMESTAMPDIFF(DAY, now(), raffles.date_end) AS remaining_days"),
            DB::raw("CONCAT('".$this->asset."',raffles.image) AS logo"),
            'type')
            ->where('raffles.active', 1)
            ->where('raffles.public', 1)
            ->where('raffles.finish', 0)
            ->whereNull('raffles.deleted_at')
            ->orderBy('raffles.id', 'DESC')
            ->paginate(1);
        return view('landing.page', [
            'title'   => 'Jimbo Sorteos',
            'raffles' => $raffles
        ]);
    }

    public function term(Request $request)
    {
        $terms_and_conditions = DB::table('settings')->where('name', 'terms_and_conditions')->first();
        return view('landing.term_conditions', [
            'title'  => 'Jimbo Sorteos',
            'terms_and_conditions' => $terms_and_conditions->value
        ]);
    }

    public function privacy(Request $request)
    {
        $policies_privacy = DB::table('settings')->where('name', 'policies_privacy')->first();
        return view('landing.privacy_policies', [
            'title'  => 'Jimbo Sorteos',
            'policies_privacy' => $policies_privacy->value
        ]);
    }

    public function game(Request $request)
    {
        $game_rules = DB::table('settings')->where('name', 'game_rules')->first();
        return view('landing.rules_game', [
            'title'  => 'Jimbo Sorteos',
            'game_rules' => $game_rules->value
        ]);
    }

    public function faq(Request $request)
    {

        $faqs = DB::table('settings')->where('name', 'faqs')->first();
        return view('landing.faqs', [
            'title'  => 'Jimbo Sorteos',
            'faqs' => $faqs->value
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function saleTicket(Request $request)
    {
        try {
            DB::beginTransaction();
            $sale =  $this->saleOfTickets($request);
            if($sale) {
                $tickets = $this->generateTickets($request, $sale->id);
                if(count($tickets)>0){
                    $ticket = Ticket::where('id', $request->ticket_id)->where('raffle_id', $request->raffle_id)->first();
                    if($ticket) {
                        $jib_unit = Setting::where('name', 'jib_unit_x_usd')->first();
                        $jib_usd = Setting::where('name', 'jib_usd')->first();
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
                        }
                    }
                    DB::commit();
                    if($status == 'approved') {
                        $operation = $request->operation;
                        $this->receipt($saleUpdate->id, $user->email, 'buyer');


                        $receipt_ope = $operation == 1 ? 'shopping' : 'sale';
                        $receipt_ope_user = $operation == 1 ? $saleUpdate->user_id : $saleUpdate->seller_id;
                        $amout_jib = ($ticket->promotion->price*$jib_unit->value)/$jib_usd->value;

                        return response()->json([
                            'success' => true,
                            'message' => 'Pago procesado exitosamente.',
                            'url_receipt'       => route('receipt', ['id' => encrypt($saleUpdate->id)])
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
