<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Country;
use App\Models\Sale;
use Illuminate\Support\Facades\File;
use App\Helpers\Helper;


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
        if ($request->ajax()) {
            $sale = Sale::select('id',  'number', 'number_culqi', 'amount', 'quantity', 'status')->get();
            return Datatables::of($sale)
                    ->addIndexColumn()
                    ->addColumn('action', function($sale){
                           $btn = '';

                        if(auth()->user()->can('detail-sale')){
                            $btn .= '<a href="'.route('panel.sales.show',['sale' => $sale->id]).'" data-toggle="tooltip" data-placement="right" title="Detalles"  data-id="'.$sale->id.'" id="det_'.$sale->id.'" class="btn btn-info btn-sm  mr-1 detailSale">
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
                        return $sale->raffle->title;
                    })
                    ->addColumn('ticket', function($sale){
                        return   $sale->ticket->promotion->name;
                    })->addColumn('amount', function($sale){
                        return   Helper::amount($sale->amount);
                    })
                    ->rawColumns(['action','status', 'raffle', 'ticket', 'amount'])
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
