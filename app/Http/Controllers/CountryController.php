<?php

namespace App\Http\Controllers;

use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Country;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\FormCountryEditRequest;
use App\Http\Requests\FormCountryCreateRequest;


class CountryController extends Controller
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
            $country = DB::table('countries')->select('id', 'name', 'description')->get();
            return Datatables::of($country)
                    ->addIndexColumn()
                    ->addColumn('action', function($country){
                           $btn = '';
                        if(auth()->user()->can('edit-role')){
                            if($country->name != 'super-admin' && $country->name != 'seller'){
                                $btn .= '<a href="'.route('panel.countries.edit',['role' => $country->id]).'" data-toggle="tooltip" data-placement="right" title="Editar"  data-id="'.$country->id.'" id="edit_'.$country->id.'" class="btn btn-warning btn-xs mr-1 editCountry">
                                            <i class="ti-pencil"></i>
                                        </a>';
                            }
                        }
                        /* if(auth()->user()->can('detail-role')){
                            $btn .= '<a href="'.route('panel.countries.detail',['role' => $country->id]).'" data-toggle="tooltip" data-placement="right" title="Detalles"  data-id="'.$country->id.'" id="det_'.$country->id.'" class="btn btn-info btn-xs  mr-1 detailCountry">
                                        <i class="ti-search"></i>
                                    </a>';
                        } */
                        if(auth()->user()->can('delete-role')){
                            if($country->name != 'super-admin' && $country->name != 'seller'){
                                $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" data-placement="right" title="Eliminar"  data-url="'.route('panel.countries.destroy',['role' => $country->id]).'" class="btn btn-danger btn-xs deleteCountry">
                                                <i class="ti-trash"></i>
                                        </a>';
                            }
                        }
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('panel.countries.index', [
            'title'              => 'Countrys',
            'title_header'       => 'Listado de countries',
            'description_module' => 'Informacion de los countries que se encuentran en el sistema.',
            'title_nav'          => 'Listado',
            'icon'               => 'icofont-settings'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('panel.countries.create', [
            'title'              => 'Countrys',
            'title_header'       => 'Registrar role',
            'description_module' => 'Registro de countries en el sistema.',
            'title_nav'          => 'Registrar',
            'icon'               => 'icofont-settings',
            'permissions'        => Permission::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FormCountryCreateRequest $request)
    {
        $store = Country::create([
            'name'        => $request->name,
            'description' => $request->description
        ])->syncPermissions($request->syncPermissions);

        if($store)
            return response()->json(['success' => true, 'message' => 'Jimbo panel notifica: Rol registrado exitosamente.'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = Auth::user()->id;
        $countryCountry = DB::table('model_has_countries')->select('role_id')->where('model_id',  $id)->pluck('role_id')->toArray();
        return view('panel.countries.show', ['title' => 'Usuarios - Perfil', 'role' => Country::find($id), 'userCountry' => $countryCountry, 'countries' => Country::all(), 'permissions' => Country::findOrFail($id)->getAllPermissions()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        $countryCountry = DB::table('model_has_countries')->select('role_id')->where('model_id',  $id)->pluck('role_id')->toArray();
        return view('panel.countries.detail', ['title' => 'Usuarios - Detalle', 'role' => Country::find($id), 'userCountry' => $countryCountry, 'countries' => Country::all(), 'permissions' => Country::findOrFail($id)->getAllPermissions()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $syncPermissions = DB::table('role_has_permissions')->select('permission_id')->where('role_id',  $id)->pluck('permission_id')->toArray();

        return view('panel.countries.edit', [
            'title'              => 'Countrys',
            'title_header'       => 'Editar Country',
            'description_module' => 'Actualice la informacion del role en el formulario de Edicion.',
            'title_nav'          => 'Editar',
            'icon'               => 'icofont-settings',
            'permissions'        => Permission::all(),
            'role'               => Country::findOrFail($id),
            'syncPermissions'    => $syncPermissions
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FormCountryEditRequest $request, Country $Country)
    {
        $country = Country::findOrFail($Country->id);

        $update = $country->update([
            'name'         => $request->name,
            'description'  => $request->description
        ]);
        $country->syncPermissions($request->syncPermissions, true);
        if($update)
            return response()->json(['success' => true, 'message' => 'Jimbo panel notifica: Rol actualizado exitosamente.'], 200);
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
            $country = Country::findOrFail($id);
            $delete = $country->delete();
            if ($delete) {
                return response()->json(['success' => true, 'message' => 'Jimbo panel notifica: Country eliminado exitosamente.'], 200);
            } else {
                return response()->json(['success' => true, 'message' => 'Jimbo panel notifica: El role no se elimino correctamente. Intente mas tarde.'], 200);
            }
        }
        abort(404);
    }
}
