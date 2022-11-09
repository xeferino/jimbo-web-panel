<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\User as Competitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\FormCompetitorRequest;
use App\Models\Country;
use App\Models\Sale AS Shopping;
use App\Models\PaymentHistory;
use App\Models\CashRequest;
use App\Models\BalanceHistory;
use App\Helpers\Helper;
use Illuminate\Support\Facades\File;


class CompetitorController extends Controller
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
        if ($request->ajax()) {
            $competitor = Competitor::select('id',  'image', DB::raw("CONCAT(names,' ',surnames) AS fullname"), 'email', 'active')->whereHas("roles", function ($q) {
                        $q->whereIn('name', ['competitor']);
                    })->whereNull('deleted_at')->get();
            return Datatables::of($competitor)
                    ->addIndexColumn()
                    ->addColumn('action', function($competitor){
                           $btn = '';
                        if(auth()->user()->can('edit-competitor')){

                            $btn .= '<a href="'.route('panel.competitors.edit',['competitor' => $competitor->id]).'" data-toggle="tooltip" data-placement="right" title="Editar"  data-id="'.$competitor->id.'" id="edit_'.$competitor->id.'" class="btn btn-warning btn-sm mr-1 editCompetitor">
                                            <i class="ti-pencil"></i>
                                    </a>';
                        }
                        if(auth()->user()->can('show-competitor')){
                            $btn .= '<a href="'.route('panel.competitors.show',['competitor' => $competitor->id]).'" data-toggle="tooltip" data-placement="right" title="Detalles"  data-id="'.$competitor->id.'" id="det_'.$competitor->id.'" class="btn btn-inverse btn-sm  mr-1 detailCompetitor">
                                        <i class="ti-eye"></i>
                                    </a>';
                        }
                        if(auth()->user()->can('delete-competitor')){
                            $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" data-placement="right" title="Eliminar"  data-url="'.route('panel.competitors.destroy',['competitor' => $competitor->id]).'" class="btn btn-danger btn-sm deleteCompetitor">
                                            <i class="ti-trash"></i>
                                    </a>';
                        }
                        return $btn;
                    })
                    ->addColumn('active', function($competitor){
                        $btn = '';
                        if($competitor->active==1){
                            $btn .= '<span class="badge badge-success" title="Activo"><i class="ti-check"></i></span>';
                        }else{
                            $btn .= '<span class="badge badge-danger" title="Inactivo"><i class="ti-close"></i></span>';
                        }
                        return $btn;
                    })
                    ->addColumn('image', function($competitor){
                        $img = $competitor->image != 'avatar.svg' ? asset('assets/images/competitors/'.$competitor->image): asset('assets/images/avatar.svg');
                        return '<img src="'.$img.'" class="img-50 img-radius" alt="User-Profile-Image">';
                    })
                    ->addColumn('role', function($competitor){
                        $btn = '';
                        $competitor = Competitor::find($competitor->id);
                        $btn .= '<span class="badge badge-inverse">'.$competitor->getRoleNames()->join('').'</span>';
                        return   $btn;
                    })
                    ->rawColumns(['action','active', 'role', 'image'])
                    ->make(true);
        }
        return view('panel.competitors.index', [
            'title'              => 'Participantes',
            'title_header'       => 'Listado de participantes',
            'description_module' => 'Informacion de los participantes que se encuentran en el sistema.',
            'title_nav'          => 'Listado',
            'icon'               => 'icofont-users'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('panel.competitors.create', [
            'title'              => 'Vendedores',
            'title_header'       => 'Registrar vendedores',
            'description_module' => 'Registrar nuevos vendedores en el sistema.',
            'title_nav'          => 'Registrar',
            'icon'               => 'icofont-user',
            'roles'              => Role::whereIn('name', ['competitor'])->get(),
            'countries'          => Country::where('active', 1)->whereNull('deleted_at')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Competitor $competitor)
    {
        $competitor                   = new Competitor();
        $competitor->name             = $request->name;
        $competitor->email            = $request->email;
        $competitor->dni              = $request->dni;
        $competitor->phone            = $request->phone;
        $competitor->balance_jib      = $request->balance_jib;
        $competitor->country_id       = $request->country_id;
        $competitor->active           = $request->active;
        $competitor->password         = Hash::make($request->password);

        if($request->file('image')){
            $file           = $request->file('image');
            $extension      = $file->getClientOriginalExtension();
            $fileName       = time().uniqid() . '.' . $extension;
            $competitor->image      = $fileName;
            $file->move(public_path('assets/images/competitors/'), $fileName);
        }else{
            $competitor->image = 'avatar.svg';
        }

        $saved = $competitor->save();
        if($saved)
        $competitor->assignRole($request->role);
            return response()->json(['success' => true, 'message' => 'Jimbo panel notifica: Vendedor registrado exitosamente.'], 200);
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

            if($request->mod == 'shopping'){
                $shopping = Shopping::select(
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
                    )->where('user_id', $id)->get();
                    return Datatables::of($shopping)
                    ->addIndexColumn()
                    ->addColumn('action', function($shopping){
                        if(auth()->user()->can('show-sale')){

                            $btn = '';
                            $shopping = Shopping::find($shopping->id);
                            $btn .= '<a href="'.route('panel.sales.show',['sale' => $shopping->id]).'" data-toggle="tooltip" data-placement="right" title="Detalles"  class="btn btn-warning btn-sm  mr-1 detailSale">
                                            <i class="ti-eye"></i>
                                        </a>';
                            return $btn;
                        }
                    })
                    ->addColumn('status', function($shopping){
                        $btn = '';
                        if($shopping->status=='approved'){
                            $btn .= '<span class="badge badge-success" title="Aprobada">Aprobada</span>';
                        }elseif($shopping->status=='refused'){
                            $btn .= '<span class="badge badge-danger" title="Rechazada">Rechazada</span>';
                        } else{
                            $btn .= '<span class="badge badge-warning" title="Pendiente">Pendiente</span>';
                        }
                        return $btn;
                    })
                    ->addColumn('raffle', function($shopping){
                        $shopping = Shopping::find($shopping->id);
                        return $shopping->raffle->title;
                    })
                    ->addColumn('ticket', function($shopping){
                        $shopping = Shopping::find($shopping->id);
                        return   $shopping->ticket->promotion->name;
                    })->addColumn('amount', function($shopping){
                        return   Helper::amount($shopping->amount);
                    })->addColumn('date', function($shopping){
                        $date = Carbon::parse($shopping->date)->format('d/m/Y H:i:s');
                        return   $date;
                    })
                    ->rawColumns(['action', 'status', 'raffle', 'ticket', 'amount', 'date'])
                    ->make(true);
            } elseif($request->mod == 'paymentHistory') {
                $payment = PaymentHistory::select(
                    'id',
                    'description',
                    'total_paid AS amount',
                    'response AS message',
                    'code_response AS number',
                    'status',
                    'created_at AS date',
                    DB::raw('(CASE
                                WHEN payment_method = "Card" THEN "Tarjeta"
                                WHEN payment_method = "Jib" THEN "Jibs"
                                ELSE "Otro"
                                END) AS method')
                    )->where('user_id', $id)->get();
                    return Datatables::of($payment)
                    ->addIndexColumn()
                    ->addColumn('action', function($payment){

                    })
                    ->addColumn('status', function($payment){
                        $btn = '';
                        if($payment->status=='approved'){
                            $btn .= '<span class="badge badge-success" title="Aprobada">Aprobada</span>';
                        }elseif($payment->status=='refused'){
                            $btn .= '<span class="badge badge-danger" title="Rechazada">Rechazada</span>';
                        } else{
                            $btn .= '<span class="badge badge-warning" title="Pendiente">Pendiente</span>';
                        }
                        return $btn;
                    })->addColumn('amount', function($payment){
                        return   $payment->amount;
                    })->addColumn('date', function($payment){
                        $date = Carbon::parse($payment->date)->format('d/m/Y H:i:s');
                        return   $date;
                    })
                    ->rawColumns(['action', 'status', 'amount', 'date'])
                    ->make(true);
            }elseif($request->mod == 'cash') {
                $cash = CashRequest::select(
                    'id',
                    'amount',
                    'date',
                    'hour',
                    'reference',
                    'description',
                    'status',
                    'user_id'
                )->where('user_id', $id)->get();
                return Datatables::of($cash)
                        ->addIndexColumn()
                        ->addColumn('action', function($cash){
                            $btn = '';
                            if(auth()->user()->can('show-cash-request')){
                                if($cash->status == 'approved') {
                                    $btn .= '<a href="'.route('panel.egress.show',['id' => $cash->id]).'" data-toggle="tooltip" data-placement="right" title="Detalle de egreso"  class="btn btn-success btn-sm  mr-1">
                                            <i class="ti-eye"></i>
                                        </a>';
                                }else{
                                    $btn .= '<a href="'.route('panel.cash.request.show',['id' => $cash->id]).'" data-toggle="tooltip" data-placement="right" title="Detalle solicitud"  class="btn btn-warning btn-sm  mr-1">
                                                <i class="ti-eye"></i>
                                            </a>';
                                }
                            }
                            return $btn;
                        })->addColumn('amount', function($cash){
                            return   Helper::amount($cash->amount);
                        })->addColumn('date', function($cash){
                            $cash = CashRequest::find($cash->id);
                            $date = explode('-', $cash->date);
                            return $date[2].'/'.$date[1].'/'.$date[0];
                        })->addColumn('user', function($cash){
                            $user = Competitor::find($cash->user_id);
                            return $user->names .' '. $user->surnames;
                        })->addColumn('status', function($cash){
                            $btn = '';
                            if($cash->status=='approved'){
                                $btn .= '<span class="badge badge-success" title="Aprobada">Aprobada</span>';
                            }elseif($cash->status=='refused'){
                                $btn .= '<span class="badge badge-danger" title="Rechazada">Rechazada</span>';
                            }elseif($cash->status=='pending'){
                                $btn .= '<span class="badge badge-danger" title="Pendiente">Pendiente</span>';
                            }elseif($cash->status=='return'){
                                $btn .= '<span class="badge badge-danger" title="Devuelta">Devuelta</span>';
                            } else{
                                $btn .= '<span class="badge badge-warning" title="Creada">Creada</span>';
                            }
                            return $btn;
                        })
                        ->rawColumns(['action', 'amount', 'date', 'user', 'status'])
                        ->make(true);

            } elseif($request->mod == 'balance') {
                $balance = BalanceHistory::select(
                    'id',
                    'reference',
                    'description',
                    DB::raw('(CASE
                                WHEN type = "debit" THEN "Debito"
                                WHEN type = "credit" THEN "Credito"
                                ELSE "Otro"
                                END) AS type'),
                    'balance AS amount',
                    DB::raw('(CASE
                                WHEN currency = "jib" THEN "Jib"
                                WHEN currency = "usd" THEN "USD"
                                ELSE "Otro"
                                END) AS currency'),
                    'date',
                    'hour',
                    'user_id'
                )->where('user_id', $id)->get();
                return Datatables::of($balance)
                        ->addIndexColumn()
                        ->addColumn('action', function($balance){
                        })->addColumn('date', function($balance){
                            $balance = BalanceHistory::find($balance->id);
                            $date = explode('-', $balance->date);
                            return $date[2].'/'.$date[1].'/'.$date[0];
                        })->rawColumns(['action', 'amount', 'date'])
                        ->make(true);
            }
        }

        return view('panel.competitors.show', [
            'title'              => 'Participantes',
            'title_header'       => 'Participante detalles',
            'description_module' => 'Informacion del participante en el sistema.',
            'title_nav'          => 'Detalles',
            'competitor'         => Competitor::findOrFail($id),
            'icon'               => 'icofont icofont-users'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        $competitorRole = DB::table('model_has_roles')->select('role_id')->where('model_id',  $id)->pluck('role_id')->toArray();
        return view('panel.competitors.detail', ['title' => 'Vendedores - Detalle', 'competitor' => User::find($id), 'competitorRole' => $competitorRole, 'roles' => Role::all(), 'permissions' => User::findOrFail($id)->getAllPermissions()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $competitorRole = DB::table('model_has_roles')->select('role_id')->where('model_id',  $id)->pluck('role_id')->toArray();
        return view('panel.competitors.edit', [
            'title'              => 'Participantes',
            'title_header'       => 'Editar participantes',
            'description_module' => 'Actualice la informacion del usuario en el formulario de Edicion.',
            'title_nav'          => 'Editar',
            'icon'               => 'icofont-user',
            'competitor'             => Competitor::find($id),
            'competitorRole'         => $competitorRole,
            'roles'              => Role::whereIn('name', ['competitor'])->get(),
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
    public function update(FormCompetitorRequest $request, Competitor $competitor)
    {
        $competitor                   = Competitor::find($competitor->id);
        $competitor->names            = $request->names;
        $competitor->surnames         = $request->surnames;
        $competitor->email            = $request->email;
        $competitor->dni              = $request->dni;
        $competitor->phone            = $request->phone;
        $competitor->address          = $request->address;
        $competitor->address_city     = $request->address_city;
        $competitor->country_id       = $request->country_id;
        $competitor->active           = $request->active==1 ? 1 : 0;
        if($request->password){
            $competitor->password     = Hash::make($request->password);
        }

        /* if($request->file('image')){
            if ($competitor->image != "avatar.svg") {
                if (File::exists(public_path('assets/images/competitors/' . $competitor->image))) {
                    File::delete(public_path('assets/images/competitors/' . $competitor->image));
                }
            }

            $file           = $request->file('image');
            $extension      = $file->getClientOriginalExtension();
            $fileName       = time() . '.' . $extension;
            $competitor->image      = $fileName;
            $file->move(public_path('assets/images/competitors/'), $fileName);
        } */
        $saved = $competitor->save();
        if($saved)
            $competitor->syncRoles($request->role);
            return response()->json(['success' => true, 'message' => 'Jimbo panel notifica: participante actualizado exitosamente.'], 200);
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
            $competitor = Competitor::findOrFail($id);
            /* if ($competitor->image != "avatar.svg") {
                if (File::exists(public_path('assets/images/competitors/' . $competitor->image))) {
                    File::delete(public_path('assets/images/competitors/' . $competitor->image));
                }
            } */
            $delete = $competitor->delete();
            if ($delete) {
                return response()->json(['success' => true, 'message' => 'Jimbo panel notifica: participante eliminado exitosamente.'], 200);
            } else {
                return response()->json(['success' => true, 'message' => 'Jimbo panel notifica: El participante no se elimino correctamente. Intente mas tarde.'], 200);
            }
        }
        abort(404);
    }
}
