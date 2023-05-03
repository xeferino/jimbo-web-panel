<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Country;
use App\Models\Sale;
use Illuminate\Support\Facades\File;
use App\Helpers\Helper;
use App\Models\TicketUser;
use App\Http\Controllers\Api\NotificationController;
use App\Models\Level;
use App\Models\LevelUser;
use App\Models\Ticket;
use App\Models\Setting;
Use App\Models\Raffle;
use App\Http\Controllers\Api\BalanceController;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\ReceiptPayment;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\FormSaleRequest;



class SaleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('receipt');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $sale = Sale::select(
                'id',
                'number',
                'number_culqi',
                'amount',
                'quantity',
                'status',
                'created_at AS date',
                DB::raw('(CASE
                            WHEN method = "card" THEN "Tarjeta"
                            WHEN method = "jib" THEN "Jibs"
                            ELSE "Otro"
                            END) AS method')
                )->get();
            return Datatables::of($sale)
                    ->addIndexColumn()
                    ->addColumn('action', function($sale){
                           $btn = '';

                        if(auth()->user()->can('show-sale')){
                            $btn .= '<a href="'.route('panel.sales.show',['sale' => $sale->id]).'" data-toggle="tooltip" data-placement="right" title="Detalles"  data-id="'.$sale->id.'" id="det_'.$sale->id.'" class="btn btn-inverse btn-sm  mr-1 detailSale">
                                        <i class="ti-eye"></i>
                                    </a>';
                        }
                        if(auth()->user()->can('edit-sale')){
                            $sale = Sale::find($sale->id);
                            if($sale->method == 'other' && $sale->status != 'approved') {
                                $btn .= '<a href="'.route('panel.sales.edit',['sale' => $sale->id]).'" data-toggle="tooltip" data-placement="right" title="Editar"  data-id="'.$sale->id.'" id="det_'.$sale->id.'" class="btn btn-warning btn-sm  mr-1 editSale">
                                            <i class="ti-pencil"></i>
                                        </a>';
                            }
                        }
                        if(auth()->user()->can('delete-sale')){
                            $sale = Sale::find($sale->id);
                            if($sale->method == 'other' && $sale->status != 'approved') {
                                $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" data-placement="right" title="Eliminar"  data-url="'.route('panel.sales.destroy',['sale' => $sale->id]).'" class="btn btn-danger btn-sm deleteSale">
                                            <i class="ti-trash"></i>
                                        </a>';
                            }
                        }
                        return $btn;
                    })
                    ->addColumn('method', function($sale){
                        $btn = '';
                        if($sale->method=='Tarjeta'){
                            $btn .= '<span class="badge badge-danger" title="Tarjeta">Tarjeta</span>';
                        }elseif($sale->method=='Jibs'){
                            $btn .= '<span class="badge badge-warning" title="Jibs">Jibs</span>';
                        } else{
                            $btn .= '<span class="badge badge-inverse" title="Otro">Otro</span>';
                        }
                        return $btn;
                    })
                    ->addColumn('status', function($sale){
                        $btn = '';
                        if($sale->status=='approved'){
                            $btn .= '<span class="badge badge-success" title="Aprobada">Aprobada</span>';
                        }elseif($sale->status=='refused'){
                            $btn .= '<span class="badge badge-danger" title="Rechazada">Rechazada</span>';
                        } else{
                            $btn .= '<span class="badge badge-danger" title="Pendiente">Pendiente</span>';
                        }
                        return $btn;
                    })
                    ->addColumn('raffle', function($sale){
                        $sale = Sale::find($sale->id);
                        return $sale->raffle->title;
                    })
                    ->addColumn('ticket', function($sale){
                        $sale = Sale::find($sale->id);
                        return   $sale->ticket->promotion->name;
                    })->addColumn('amount', function($sale){
                        return   Helper::amount($sale->amount);
                    })->addColumn('date', function($sale){
                        $date = Carbon::parse($sale->date)->format('d/m/Y H:i:s');
                        return   $date;
                    })->addColumn('id', function($sale){
                        $sale = Sale::find($sale->id);
                        return str_pad($sale->id,6,"0",STR_PAD_LEFT);
                    })->addColumn('seller', function($sale){
                        $sale = Sale::find($sale->id);
                        return !empty($sale->Seller) ? $sale->Seller->names. ' '.$sale->Seller->surnames : '-----';
                    })
                    ->rawColumns(['action', 'status', 'raffle', 'ticket', 'amount', 'date', 'method', 'id', 'seller'])
                    ->make(true);
        }

        return view('panel.sales.index', [
            'title'              => 'Ventas',
            'title_header'       => 'Listado de Ventas',
            'description_module' => 'Informacion de las ventas que se encuentran en el sistema.',
            'title_nav'          => 'Listado',
            'icon'               => 'icofont icofont-bars'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if ($request->ajax()) {
            $ticket = Sale::find($id);
            $sale = TicketUser::select(
                'id',
                'serial'
                )->where('sale_id', $id)->where('raffle_id', $ticket->raffle_id)->where('ticket_id', $ticket->ticket_id)->get();
            return Datatables::of($sale)
                    ->addIndexColumn()
                    ->addColumn('action', function($sale){
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        if(\Request::wantsJson()){

            $sale = Sale::findOrFail($id);
            $sale->status = 'approved';

            if($sale->save()) {
                if ($sale->status == 'approved') {
                    $this->sendReceiptSale($sale->id, $sale->Seller->email, 'seller');
                    $this->sendReceiptSale($sale->id, $sale->email, 'buyer');
                }

                return response()->json([
                    'success'    => true,
                    'message' => 'Jimbo panel notifica: Venta aprobada exitosamente.'
                ], 200);
            }
            return response()->json([
                'success'    => false,
                'message' => 'Jimbo panel notifica: Error! la venta no se ha aprobado exitosamente.'
            ], 200);
        }

        return view('panel.sales.show', [
            'title'              => 'Ventas',
            'title_header'       => 'Detalles de la venta',
            'description_module' => 'Informacion de la venta en el sistema.',
            'title_nav'          => 'Detalles',
            'sale'               => Sale::findOrFail($id),
            'icon'               => 'icofont icofont-bars'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if(\Request::wantsJson()){
            $promotions = [];

            foreach (Raffle::find($request->raffle_id)->Tickets->where('total', '<>', '0') as $key => $value) {
                # code...
                array_push($promotions, [
                    'id'        => $value->id,
                    'name'      => $value->promotion->name,
                    'code'      => $value->promotion->code,
                    'price'     => Helper::amount($value->promotion->price),
                    'quantity'  => $value->promotion->quantity,
                ]);
            }

            return response()->json([
                'success'    => true,
                'promotions' => $promotions
            ], 200);
        }

        $raffles = Raffle::select(
            'raffles.id',
            'raffles.title',
            'raffles.cash_to_draw',
            'raffles.date_start',
            'raffles.date_end',
            'raffles.date_release',
            DB::raw("TIMESTAMPDIFF(DAY, now(), raffles.date_end) AS remaining_days"),
            'type')
            ->where('raffles.active', 1)
            ->where('raffles.public', 1)
            ->where('raffles.finish', 0)
            ->whereNull('raffles.deleted_at')
            ->orderBy('raffles.id', 'DESC')
            ->get();

        return view('panel.sales.create', [
            'title'              => 'Ventas',
            'title_header'       => 'Registrar venta',
            'description_module' => 'Registrar nuevas en el sistema.',
            'title_nav'          => 'Registrar',
            'icon'               => 'icofont-bars',
            'countries'          => Country::where('active', 1)->whereNull('deleted_at')->get(),
            'raffles'            => $raffles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FormSaleRequest $request, Sale $sale)
    {
        $ticket = Ticket::where('id', $request->ticket_id)->where('raffle_id', $request->raffle_id)->first();

        if ($ticket) {
            $sale               = new Sale();
            $sale->name         = $request->fullnames;
            $sale->email        = $request->email;
            $sale->dni          = $request->dni;
            $sale->phone        = $request->phone;
            $sale->address      = $request->address;
            $sale->country_id   = $request->country_id;
            $sale->amount       = $ticket->promotion->price;
            $sale->number       = time();
            $sale->quantity     = $ticket->promotion->quantity;
            $sale->ticket_id    = $ticket->id;
            $sale->seller_id    = Auth::user()->id;
            $sale->user_id      = null;
            $sale->raffle_id    = $ticket->raffle_id;
            $sale->status       = $request->status;
            $sale->method       = 'other';

            if ($sale->save()){
                $tickets = [];
                for ($i = 1; $i <= $ticket->promotion->quantity; $i++) {
                    array_push($tickets, [
                        'serial'        =>  substr(sha1($ticket->id.$i.time()), 0, 8),
                        'ticket_id'     =>  $ticket->id,
                        'raffle_id'     =>  $ticket->raffle_id,
                        'user_id'       =>  null,
                        'sale_id'       =>  $sale->id,
                        'created_at'    =>  now(),
                        'updated_at'    =>  now(),
                    ]);
                }
                $ticket->total = $ticket->total-$ticket->promotion->quantity;
                $ticket->save();
                TicketUser::insert($tickets);
                if ($sale->status == 'approved') {
                    $this->sendReceiptSale($sale->id, $sale->Seller->email, 'seller');
                    $this->sendReceiptSale($sale->id, $sale->email, 'buyer');
                }
                return response()->json([
                    'success' => true,
                    'message' => 'Jimbo panel notifica: Nueva venta registrada exitosamente.',
                    'url'     => route('panel.sales.show',['sale' => $sale->id])
                ], 200);
            }
        }
        return response()->json(['success' => false, 'message' => 'Jimbo panel notifica: Error! al registrar la nueva venta.'], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $raffles = Raffle::select(
            'raffles.id',
            'raffles.title',
            'raffles.cash_to_draw',
            'raffles.date_start',
            'raffles.date_end',
            'raffles.date_release',
            DB::raw("TIMESTAMPDIFF(DAY, now(), raffles.date_end) AS remaining_days"),
            'type')
            ->where('raffles.active', 1)
            ->where('raffles.public', 1)
            ->where('raffles.finish', 0)
            ->whereNull('raffles.deleted_at')
            ->orderBy('raffles.id', 'DESC')
            ->get();

        return view('panel.sales.edit', [
            'title'              => 'Ventas',
            'title_header'       => 'Editar venta',
            'description_module' => 'Editar nuevas en el sistema.',
            'title_nav'          => 'Editar',
            'icon'               => 'icofont-bars',
            'countries'          => Country::where('active', 1)->whereNull('deleted_at')->get(),
            'raffles'            => $raffles,
            'sale'               => Sale::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FormSaleRequest $request, Sale $sale)
    {
        $sale               = Sale::find($sale->id);
        $sale->name         = $request->fullnames;
        $sale->email        = $request->email;
        $sale->dni          = $request->dni;
        $sale->phone        = $request->phone;
        $sale->address      = $request->address;
        $sale->country_id   = $request->country_id;
        $sale->status       = $request->status;
        if ($sale->save()){
            if ($sale->status == 'approved') {
                $this->sendReceiptSale($sale->id, $sale->Seller->email, 'seller');
                $this->sendReceiptSale($sale->id, $sale->email, 'buyer');
            }
            return response()->json([
                'success' => true,
                'message' => 'Jimbo panel notifica: Venta actualizada exitosamente.',
                'url'     => route('panel.sales.show',['sale' => $sale->id])
            ], 200);
        }
        return response()->json(['success' => false, 'message' => 'Jimbo panel notifica: Error! al actualizar la venta.'], 200);
    }

    /**
     * Send email receipt sale.
     *
     * @return \Illuminate\Http\Response
     */
    private function sendReceiptSale($id, $email, $type = null)
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

    public function test()
    {
        /* $ticket = Ticket::where('id', $request->ticket_id)->where('raffle_id', $request->raffle_id)->first();

        if ($ticket) {
            $sale               = Sale::find($sale->id);

            $delete = false; */
            /* if ($sale->raffle_id == $request->raffle_id) {
                if ($sale->ticket_id != $request->ticket_id) {
                    $sale->TicketsUsers()->delete();
                    $ticket = Ticket::find($sale->ticket_id);
                    $ticket->total = $ticket->total + $sale->quantity;
                    $ticket->save();
                    $delete = true;

                }
            } elseif ($sale->raffle_id != $request->raffle_id) {
                $sale->TicketsUsers()->delete();
                $ticket = Ticket::find($sale->ticket_id);
                $ticket->total = $ticket->total + $sale->quantity;
                $ticket->save();
                $delete = true;
            } */

           /*  $sale->name         = $request->fullnames;
            $sale->email        = $request->email;
            $sale->dni          = $request->dni;
            $sale->phone        = $request->phone;
            $sale->address      = $request->address;
            $sale->country_id   = $request->country_id; */
            //$sale->amount       = $ticket->promotion->price;
            //$sale->number       = time();
            //$sale->quantity     = $ticket->promotion->quantity;
            //$sale->ticket_id    = $ticket->id;
            //$sale->seller_id    = Auth::user()->id;
            //$sale->user_id      = null;
            //$sale->raffle_id    = $ticket->raffle_id;
            //$sale->status       = $request->status;

            /*if ($sale->save()){
               if ($delete) {
                    $tickets = [];
                    for ($i = 1; $i <= $ticket->promotion->quantity; $i++) {
                        array_push($tickets, [
                            'serial'        =>  substr(sha1($ticket->id.$i.time()), 0, 8),
                            'ticket_id'     =>  $ticket->id,
                            'raffle_id'     =>  $ticket->raffle_id,
                            'user_id'       =>  null,
                            'sale_id'       =>  $sale->id,
                            'created_at'    =>  now(),
                            'updated_at'    =>  now(),
                        ]);
                    }

                    $ticket->total = $ticket->total-$ticket->promotion->quantity;
                    $ticket->save();
                    TicketUser::insert($tickets);
                }
                return response()->json(['success' => true, 'message' => 'Jimbo panel notifica: Venta actualizada exitosamente.'], 200);
            }*/
        //}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(\Request::wantsJson()){
            $sale = Sale::findOrFail($id);
            $sale->TicketsUsers()->delete();
            $ticket = Ticket::find($sale->ticket_id);
            $ticket->total = $ticket->total + $sale->quantity;
            $ticket->save();

            $delete = $sale->delete();
            if ($delete) {
                return response()->json(['success' => true, 'message' => 'Jimbo panel notifica: Venta eliminada exitosamente.'], 200);
            } else {
                return response()->json(['success' => true, 'message' => 'Jimbo panel notifica: La venta no se elimino correctamente. Intente mas tarde.'], 200);
            }
        }
        abort(404);
    }


    /**
     * Display a single graphics of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function receipt(Request $request, $id)
    {
        try {
            //code...
            $id = decrypt($id);
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
                'receipt'   => null
            ];

            $pdf = Pdf::loadView('panel.sales.receipt', $data);
            $name = "Recibo-de-".$data['type']."-".str_pad($sale->id,6,"0",STR_PAD_LEFT).".pdf";
            return $pdf->stream($name);
        } catch (\Throwable $th) {
            abort(400);
        }
    }
}
