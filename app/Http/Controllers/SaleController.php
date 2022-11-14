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
use App\Models\Setting;
use App\Http\Controllers\Api\BalanceController;



class SaleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $month = date('m');
        $month_name = null;
        /*if ($month == '12') {
            $month = '11';
            $month_name = 'Noviembre';
        }elseif($month == '11') {
            $month = '10';
            $month_name = 'Octubre';
        }elseif($month == '10') {
            $month = '09';
            $month_name = 'Septiembre';
        }elseif($month == '09') {
            $month = '08';
            $month_name = 'Agosto';
        }elseif($month == '08') {
            $month = '07';
            $month_name = 'Julio';
        }elseif($month == '07') {
            $month = '06';
            $month_name = 'Junio';
        }elseif($month == '06') {
            $month = '05';
            $month_name = 'Mayo';
        }elseif($month == '05') {
            $month = '04';
            $month_name = 'Abril';
        }elseif($month == '04') {
            $month = '03';
            $month_name = 'Marzo';
        }elseif($month == '03') {
            $month = '02';
            $month_name = 'Febrero';
        }elseif($month == '02') {
            $month = '01';
            $month_name = 'Enero';

        }elseif($month == '01') {
            $month = '12';
            $month_name = 'Diciembre';
        }*/

        $level_group_junior  = Setting::where('name', 'level_group_junior')->first();
        $level_group_middle  = Setting::where('name', 'level_group_middle')->first();
        $level_group_master  = Setting::where('name', 'level_group_master')->first();

        $level_percent_group_junior = Setting::where('name', 'level_percent_group_junior')->first();
        $level_percent_group_middle = Setting::where('name', 'level_percent_group_middle')->first();
        $level_percent_group_master = Setting::where('name', 'level_percent_group_master')->first();

        $users = Sale::select(
            'users.id AS user_id',
            DB::raw("CONCAT(users.names,' ',users.surnames) AS fullnames"),
            'users.email',
            DB::raw('SUM(sales.amount) as amount'),
            'level_users.referral_id',
            'level_users.level_id',
            'levels.name as level'
            )
            ->join('level_users', 'level_users.seller_id', '=', 'sales.seller_id')
            ->join('users', 'users.id', '=', 'level_users.referral_id')
            ->leftJoin('levels', 'levels.id', '=', 'level_users.level_id')
            ->groupBy('level_users.referral_id')
            ->groupBy('level_users.level_id')
            ->whereNotNull('sales.seller_id')
            ->whereNull('sales.user_id')
            ->whereMonth('sales.created_at', $month)
            ->orderBy('sales.id','DESC')
            ->get();

        $data = [];
        foreach ($users as $key => $value) {
            # code...
            $level = null;
            $bonus = 0;
            if($value->level == 'junior' && $value->amount>=$level_group_junior->value) {
                $level = $value->level;
                $bonus = (($value->amount/100)*$level_percent_group_junior->value);
            }elseif($value->level == 'middle' && $value->amount>=$level_group_middle->value) {
                $level = $value->level;
                $bonus = (($value->amount/100)*$level_percent_group_middle->value);
            }elseif($value->level == 'master' && $value->amount>=$level_group_master->value) {
                $level = $value->level;
                $bonus = (($value->amount/100)*$level_percent_group_master->value);
            }

            if($bonus > 0) {
                $user = User::find($value->user_id);
                $user->balance_usd  =  $user->balance_usd+$bonus;
                $user->save();
                BalanceController::store('Cierre ventas del mes de '.$month_name.' de referidos', 'credit', $bonus, 'usd', $user->id);
                NotificationController::store('Cierre ventas del mes de '.$month_name.' de referidos', 'Hola, '.$user->email.' has recibido un bono de '.Helper::amount($bonus).', con Jimbo siempre ganas', $user->id);
            }
            array_push($data, [
                'user_id'   => $value->user_id,
                'level'     => $level,
                'bonus'     => $bonus,
                'amount'    => $value->amount
            ]);
        }

        return $data;

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
                            $btn .= '<a href="'.route('panel.sales.show',['sale' => $sale->id]).'" data-toggle="tooltip" data-placement="right" title="Detalles"  data-id="'.$sale->id.'" id="det_'.$sale->id.'" class="btn btn-warning btn-sm  mr-1 detailSale">
                                        <i class="ti-eye"></i>
                                    </a>';
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
                            $btn .= '<span class="badge badge-warning" title="Pendiente">Pendiente</span>';
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
                    })
                    ->rawColumns(['action', 'status', 'raffle', 'ticket', 'amount', 'date'])
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
    public function create()
    {
        return view('panel.sales.create', [
            'title'              => 'Vendedores',
            'title_header'       => 'Registrar vendedores',
            'description_module' => 'Registrar nuevos vendedores en el sistema.',
            'title_nav'          => 'Registrar',
            'icon'               => 'icofont-users',
            'roles'              => Role::whereIn('name', ['sale'])->get(),
            'countries'          => Country::where('active', 1)->whereNull('deleted_at')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Sale $sale)
    {
        $sale                   = new Sale();
        $sale->name             = $request->name;
        $sale->email            = $request->email;
        $sale->dni              = $request->dni;
        $sale->phone            = $request->phone;
        $sale->balance_jib      = $request->balance_jib;
        $sale->country_id       = $request->country_id;
        $sale->active           = $request->active;
        $sale->password         = Hash::make($request->password);

        if($request->file('image')){
            $file           = $request->file('image');
            $extension      = $file->getClientOriginalExtension();
            $fileName       = time().uniqid() . '.' . $extension;
            $sale->image      = $fileName;
            $file->move(public_path('assets/images/sales/'), $fileName);
        }else{
            $sale->image = 'avatar.svg';
        }

        $saved = $sale->save();
        if($saved)
        $sale->assignRole($request->role);
            return response()->json(['success' => true, 'message' => 'Jimbo panel notifica: Vendedor registrado exitosamente.'], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $saleRole = DB::table('model_has_roles')->select('role_id')->where('model_id',  $id)->pluck('role_id')->toArray();
        return view('panel.sales.edit', [
            'title'              => 'Vendedores',
            'title_header'       => 'Editar vendedores',
            'description_module' => 'Actualice la informacion del usuario en el formulario de Edicion.',
            'title_nav'          => 'Editar',
            'icon'               => 'icofont-users',
            'sale'             => Sale::find($id),
            'saleRole'         => $saleRole,
            'roles'              => Role::whereIn('name', ['sale'])->get(),
            'countries'          => Country::where('active', 1)->whereNull('deleted_at')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FormUserEditRequest $request, Sale $sale)
    {
        $sale                   = Sale::find($sale->id);
        $sale->name             = $request->name;
        $sale->email            = $request->email;
        $sale->dni              = $request->dni;
        $sale->phone            = $request->phone;
        $sale->balance_jib      = $request->balance_jib;
        $sale->country_id       = $request->country_id;
        $sale->active           = $request->active==1 ? 1 : 0;
        if($request->password){
            $sale->password     = Hash::make($request->password);
        }

        if($request->file('image')){
            if ($sale->image != "avatar.svg") {
                if (File::exists(public_path('assets/images/sales/' . $sale->image))) {
                    File::delete(public_path('assets/images/sales/' . $sale->image));
                }
            }

            $file           = $request->file('image');
            $extension      = $file->getClientOriginalExtension();
            $fileName       = time() . '.' . $extension;
            $sale->image      = $fileName;
            $file->move(public_path('assets/images/sales/'), $fileName);
        }
        $saved = $sale->save();
        if($saved)
            $sale->syncRoles($request->role);
            return response()->json(['success' => true, 'message' => 'Jimbo panel notifica: Vendedor actualizado exitosamente.'], 200);
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
            /* if ($sale->image != "avatar.svg") {
                if (File::exists(public_path('assets/images/sales/' . $sale->image))) {
                    File::delete(public_path('assets/images/sales/' . $sale->image));
                }
            } */
            $delete = $sale->delete();
            if ($delete) {
                return response()->json(['success' => true, 'message' => 'Jimbo panel notifica: Vendedor eliminado exitosamente.'], 200);
            } else {
                return response()->json(['success' => true, 'message' => 'Jimbo panel notifica: El Vendedor no se elimino correctamente. Intente mas tarde.'], 200);
            }
        }
        abort(404);
    }
}
