<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\User as Competitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\FormUserEditRequest;
use App\Http\Requests\FormUserCreateRequest;
use App\Models\Country;
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
            $competitor = Competitor::select('id',  'image', 'name AS fullname', 'email', 'active')->whereHas("roles", function ($q) {
                        $q->whereIn('name', ['competitor']);
                    })->whereNull('deleted_at')->get();
            return Datatables::of($competitor)
                    ->addIndexColumn()
                    ->addColumn('action', function($competitor){
                           $btn = '';
                        if(auth()->user()->can('edit-competitor')){

                            $btn .= '<a href="'.route('panel.competitors.edit',['competitor' => $competitor->id]).'" data-toggle="tooltip" data-placement="right" title="Editar"  data-id="'.$competitor->id.'" id="edit_'.$competitor->id.'" class="btn btn-warning btn-sm mr-1 editSeller">
                                            <i class="ti-pencil"></i>
                                    </a>';
                        }
                        if(auth()->user()->can('detail-competitor')){
                            $btn .= '<a href="'.route('panel.competitors.detail',['competitor' => $competitor->id]).'" data-toggle="tooltip" data-placement="right" title="Detalles"  data-id="'.$competitor->id.'" id="det_'.$competitor->id.'" class="btn btn-info btn-sm  mr-1 detailSeller">
                                        <i class="ti-search"></i>
                                    </a>';
                        }
                        if(auth()->user()->can('delete-competitor')){
                            $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" data-placement="right" title="Eliminar"  data-url="'.route('panel.competitors.destroy',['competitor' => $competitor->id]).'" class="btn btn-danger btn-sm deleteSeller">
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
    public function store(FormUserCreateRequest $request, Seller $competitor)
    {
        $competitor                   = new Seller();
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
    public function show($id)
    {
        $id = Auth::user()->id;
        $competitorRole = DB::table('model_has_roles')->select('role_id')->where('model_id',  $id)->pluck('role_id')->toArray();
        return view('panel.competitors.show', ['title' => 'Vendedores - Perfil', 'competitor' => User::find($id), 'competitorRole' => $competitorRole, 'roles' => Role::all(), 'permissions' => User::findOrFail($id)->getAllPermissions()]);
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
            'title'              => 'Vendedores',
            'title_header'       => 'Editar vendedores',
            'description_module' => 'Actualice la informacion del usuario en el formulario de Edicion.',
            'title_nav'          => 'Editar',
            'icon'               => 'icofont-user',
            'competitor'             => Seller::find($id),
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
    public function update(FormUserEditRequest $request, Seller $competitor)
    {
        $competitor                   = Seller::find($competitor->id);
        $competitor->name             = $request->name;
        $competitor->email            = $request->email;
        $competitor->dni              = $request->dni;
        $competitor->phone            = $request->phone;
        $competitor->balance_jib      = $request->balance_jib;
        $competitor->country_id       = $request->country_id;
        $competitor->active           = $request->active==1 ? 1 : 0;
        if($request->password){
            $competitor->password     = Hash::make($request->password);
        }

        if($request->file('image')){
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
        }
        $saved = $competitor->save();
        if($saved)
            $competitor->syncRoles($request->role);
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
            $competitor = Seller::findOrFail($id);
            /* if ($competitor->image != "avatar.svg") {
                if (File::exists(public_path('assets/images/competitors/' . $competitor->image))) {
                    File::delete(public_path('assets/images/competitors/' . $competitor->image));
                }
            } */
            $delete = $competitor->delete();
            if ($delete) {
                return response()->json(['success' => true, 'message' => 'Jimbo panel notifica: Vendedor eliminado exitosamente.'], 200);
            } else {
                return response()->json(['success' => true, 'message' => 'Jimbo panel notifica: El Vendedor no se elimino correctamente. Intente mas tarde.'], 200);
            }
        }
        abort(404);
    }
}
