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
use App\Models\Country;
use Illuminate\Support\Facades\Mail;
use Exception;
use App\Models\Slider;
use App\Models\TicketUser;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use GuzzleHttp\Client;

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
            'raffles' => $raffles,
            'countries' => Country::select('id', 'name', 'code', 'iso', 'img', 'active', 'currency', 'exchange_rate')->whereNull('deleted_at')->get(),
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

    public function pay(Request $request)
    {
        //dd($this->receipt(190, $request->data['email'], 'buyer'));

        try {
            DB::beginTransaction();
            $sale =  $this->saleOfTickets($request->data);
            if($sale) {
                $tickets = $this->generateTickets($request->data, $sale->id);
                if(count($tickets)>0){
                    $ticket = Ticket::where('id', $request->data['ticket_id'])->where('raffle_id', $request->data['raffle_id'])->first();
                    if($ticket) {
                        //cargo que se le aplica a tarjeta por la compra
                        $charge  = [
                            "amount" => $ticket->promotion->price*100,
                            "capture" => true,
                            "currency_code" => "USD",
                            "description" => $ticket->promotion->quantity.' Boltetos por '.Helper::amount($ticket->promotion->price),
                            "email" => $request->data['email'],
                            "installments" => 0,
                            "source_id" => $request->data['source_id']
                        ];

                        $payment = PaymentController::payment(null, $charge);
                        $pay =  $payment->object ?? 'error';


                        if ($pay == 'charge') {
                            $ticket->total = $ticket->total-$ticket->promotion->quantity;
                            $ticket->save();
                            $saleUpdate = Sale::find($sale->id);
                            $saleUpdate->status = 'approved';
                            $saleUpdate->number_culqi = $payment->reference_code;
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
                    }

                    DB::commit();
                    if($pay == 'charge') {
                        $this->receipt($saleUpdate->id, $request->data['email'], 'buyer');
                        return response()->json([
                            'success' => true,
                            'message' => 'Pago procesado exitosamente.',
                        ], 200);
                    }
                }
            }
            return response()->json([
                'error'             => true,
                'message'           => 'El pago no se proceso con exito.',
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
        $ticket = Ticket::where('id', $data['ticket_id'])->where('raffle_id', $data['raffle_id'])->first();
        $sale = null;
        if ($ticket) {
            $sale = new Sale();
            $fullnames        =   $data['names'] . ' ' . $data['surnames'];
            $sale->name       =   $fullnames;
            $sale->dni        =   $data['dni'];
            $sale->phone      =   $data['phone'];
            $sale->email      =   $data['email'];
            $sale->address    =   $data['address'];
            $sale->country_id =   $data['country'];
            $sale->amount     =   $ticket->promotion->price;
            $sale->number     =   time();
            $sale->quantity   =   $ticket->promotion->quantity;
            $sale->ticket_id  =   $ticket->id;
            $sale->seller_id  =   null;
            $sale->user_id    =   null;
            $sale->raffle_id  =   $data['raffle_id'];
            $sale->status     =   'pending';
            $sale->method     =   'other';
            $sale->save();
            return $sale;
        }
        return $sale;
    }

    private function generateTickets($data, $sale_id) {
        $ticket = Ticket::where('id', $data['ticket_id'])->where('raffle_id', $data['raffle_id'])->first();
        $tickets = [];
        if ($ticket) {
            for ($i = 1; $i <= $ticket->promotion->quantity; $i++) {
                array_push($tickets, [
                    'serial'        =>  substr(sha1($ticket->id.$i.time()), 0, 8),
                    'ticket_id'     =>  $ticket->id,
                    'raffle_id'     =>  $ticket->raffle_id,
                    'user_id'       =>  null,
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
            $operation = 'shopping';
            $data = [];
            $seller = null;
            $buyer = null;
            $jib_unit = Setting::where('name', 'jib_unit_x_usd')->first();
            $jib_usd = Setting::where('name', 'jib_usd')->first();
            $amout_jib = null;

            if($operation == 'shopping'){
                if($sale){
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
        } catch (Exception $e) {
            return response()->json([
                'message' =>  $e->getMessage()
            ], 400);
        }
    }
}
