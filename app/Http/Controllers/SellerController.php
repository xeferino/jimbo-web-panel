<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\User as Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\FormSellerRequest;
use App\Models\Country;
use App\Models\Sale;
use Illuminate\Support\Facades\File;
use App\Helpers\Helper;


class SellerController extends Controller
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
            $seller = Seller::select('id',  'image', DB::raw("CONCAT(names,' ',surnames) AS fullname"), 'email', 'active')->whereHas("roles", function ($q) {
                        $q->whereIn('name', ['seller']);
                    })->whereNull('deleted_at')->get();
            return Datatables::of($seller)
                    ->addIndexColumn()
                    ->addColumn('action', function($seller){
                           $btn = '';
                        if(auth()->user()->can('edit-seller')){

                            $btn .= '<a href="'.route('panel.sellers.edit',['seller' => $seller->id]).'" data-toggle="tooltip" data-placement="right" title="Editar"  data-id="'.$seller->id.'" id="edit_'.$seller->id.'" class="btn btn-warning btn-sm mr-1 editSeller">
                                            <i class="ti-pencil"></i>
                                    </a>';
                        }
                        if(auth()->user()->can('show-seller')){
                            $btn .= '<a href="'.route('panel.sellers.show',['seller' => $seller->id]).'" data-toggle="tooltip" data-placement="right" title="Detalles"  data-id="'.$seller->id.'" id="det_'.$seller->id.'" class="btn btn-inverse btn-sm  mr-1 detailSeller">
                                        <i class="ti-eye"></i>
                                    </a>';
                        }
                        if(auth()->user()->can('delete-seller')){
                            $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" data-placement="right" title="Eliminar"  data-url="'.route('panel.sellers.destroy',['seller' => $seller->id]).'" class="btn btn-danger btn-sm deleteSeller">
                                            <i class="ti-trash"></i>
                                    </a>';
                        }
                        return $btn;
                    })
                    ->addColumn('active', function($seller){
                        $btn = '';
                        if($seller->active==1){
                            $btn .= '<span class="badge badge-success" title="Activo"><i class="ti-check"></i></span>';
                        }else{
                            $btn .= '<span class="badge badge-danger" title="Inactivo"><i class="ti-close"></i></span>';
                        }
                        return $btn;
                    })
                    ->addColumn('image', function($seller){
                        $img = $seller->image != 'avatar.svg' ? asset('assets/images/sellers/'.$seller->image): asset('assets/images/avatar.svg');
                        return '<img src="'.$img.'" class="img-50 img-radius" alt="User-Profile-Image">';
                    })
                    ->addColumn('role', function($seller){
                        $btn = '';
                        $seller = Seller::find($seller->id);
                        $btn .= '<span class="badge badge-inverse">'.$seller->getRoleNames()->join('').'</span>';
                        return   $btn;
                    })
                    ->rawColumns(['action','active', 'role', 'image'])
                    ->make(true);
        }
        return view('panel.sellers.index', [
            'title'              => 'Vendedores',
            'title_header'       => 'Listado de vendedores',
            'description_module' => 'Informacion de los vendedores que se encuentran en el sistema.',
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
        return view('panel.sellers.create', [
            'title'              => 'Vendedores',
            'title_header'       => 'Registrar vendedores',
            'description_module' => 'Registrar nuevos vendedores en el sistema.',
            'title_nav'          => 'Registrar',
            'icon'               => 'icofont-users',
            'roles'              => Role::whereIn('name', ['seller'])->get(),
            'countries'          => Country::where('active', 1)->whereNull('deleted_at')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FormSellerRequest $request, Seller $seller)
    {
        $seller                   = new Seller();
        $seller->names            = $request->names;
        $seller->surnames         = $request->surnames;
        $seller->email            = $request->email;
        $seller->dni              = $request->dni;
        $seller->phone            = $request->phone;
        $seller->address          = $request->address;
        $seller->address_city     = $request->address_city;
        //$seller->balance_jib      = $request->balance_jib;
        $seller->country_id       = $request->country_id;
        $seller->active           = $request->active;
        $seller->password         = Hash::make($request->password);

        if($request->file('image')){
            $file           = $request->file('image');
            $extension      = $file->getClientOriginalExtension();
            $fileName       = time().uniqid() . '.' . $extension;
            $seller->image      = $fileName;
            $file->move(public_path('assets/images/sellers/'), $fileName);
        }else{
            $seller->image = 'avatar.svg';
        }

        $saved = $seller->save();
        if($saved)
        $seller->assignRole($request->role);
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
                )->where('seller_id', $id)->get();
                return Datatables::of($sale)
                ->addIndexColumn()
                ->addColumn('action', function($sale){
                    $btn = '';
                    $sale = Sale::find($sale->id);
                    $btn .= '<a href="#"
                                data-toggle="tooltip"
                                data-placement="right"
                                title="Detalles del comprador"
                                data-name="'.$sale->name.'"
                                data-dni="'.$sale->dni.'"
                                data-email="'.$sale->email.'"
                                data-phone="'.$sale->phone.'"
                                data-address="'.$sale->address.'"
                                data-country="'.$sale->country->name.'"
                                id="det_'.$sale->id.'"
                                class="btn btn-inverse btn-sm  mr-1 detailSale">
                                <i class="ti-user"></i>
                            </a>';
                    if(auth()->user()->can('show-sale')){
                        $btn .= '<a href="'.route('panel.sales.show',['sale' => $sale->id]).'" data-toggle="tooltip" data-placement="right" title="Detalles"  class="btn btn-warning btn-sm  mr-1 detailSale">
                                        <i class="ti-eye"></i>
                                    </a>';
                        return $btn;
                    }
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

        return view('panel.sellers.show', [
            'title'              => 'Vendedores',
            'title_header'       => 'Vendedor detalles',
            'description_module' => 'Informacion del vendedor en el sistema.',
            'title_nav'          => 'Detalles',
            'seller'             => Seller::findOrFail($id),
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
        $sellerRole = DB::table('model_has_roles')->select('role_id')->where('model_id',  $id)->pluck('role_id')->toArray();
        return view('panel.sellers.detail', ['title' => 'Vendedores - Detalle', 'seller' => User::find($id), 'sellerRole' => $sellerRole, 'roles' => Role::all(), 'permissions' => User::findOrFail($id)->getAllPermissions()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sellerRole = DB::table('model_has_roles')->select('role_id')->where('model_id',  $id)->pluck('role_id')->toArray();
        return view('panel.sellers.edit', [
            'title'              => 'Vendedores',
            'title_header'       => 'Editar vendedores',
            'description_module' => 'Actualice la informacion del usuario en el formulario de Edicion.',
            'title_nav'          => 'Editar',
            'icon'               => 'icofont-users',
            'seller'             => Seller::find($id),
            'sellerRole'         => $sellerRole,
            'roles'              => Role::whereIn('name', ['seller'])->get(),
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
    public function update(FormSellerRequest $request, Seller $seller)
    {
        $seller                   = Seller::find($seller->id);
        $seller->names            = $request->names;
        $seller->surnames         = $request->surnames;
        $seller->email            = $request->email;
        $seller->dni              = $request->dni;
        $seller->phone            = $request->phone;
        $seller->address          = $request->address;
        $seller->address_city     = $request->address_city;
        $seller->country_id       = $request->country_id;
        $seller->active           = $request->active==1 ? 1 : 0;
        if($request->password){
            $seller->password     = Hash::make($request->password);
        }

        if($request->file('image')){
            if ($seller->image != "avatar.svg") {
                if (File::exists(public_path('assets/images/sellers/' . $seller->image))) {
                    File::delete(public_path('assets/images/sellers/' . $seller->image));
                }
            }

            $file           = $request->file('image');
            $extension      = $file->getClientOriginalExtension();
            $fileName       = time() . '.' . $extension;
            $seller->image      = $fileName;
            $file->move(public_path('assets/images/sellers/'), $fileName);
        }
        $saved = $seller->save();
        if($saved)
            $seller->syncRoles($request->role);
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
            $seller = Seller::findOrFail($id);
            /* if ($seller->image != "avatar.svg") {
                if (File::exists(public_path('assets/images/sellers/' . $seller->image))) {
                    File::delete(public_path('assets/images/sellers/' . $seller->image));
                }
            } */
            $delete = $seller->delete();
            if ($delete) {
                return response()->json(['success' => true, 'message' => 'Jimbo panel notifica: Vendedor eliminado exitosamente.'], 200);
            } else {
                return response()->json(['success' => true, 'message' => 'Jimbo panel notifica: El Vendedor no se elimino correctamente. Intente mas tarde.'], 200);
            }
        }
        abort(404);
    }
}
