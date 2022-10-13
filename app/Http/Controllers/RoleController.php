<?php

namespace App\Http\Controllers;

use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\FormRoleEditRequest;
use App\Http\Requests\FormRoleCreateRequest;


class RoleController extends Controller
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
            $role = DB::table('roles')->select('id', 'name', 'description')->get();
            return Datatables::of($role)
                    ->addIndexColumn()
                    ->addColumn('action', function($role){
                           $btn = '';
                        if(auth()->user()->can('edit-role')){
                            //if($role->name != 'super-admin' && $role->name != 'seller' && $role->name != 'competitor' ){
                                $btn .= '<a href="'.route('panel.roles.edit',['role' => $role->id]).'" data-toggle="tooltip" data-placement="right" title="Editar"  data-id="'.$role->id.'" id="edit_'.$role->id.'" class="btn btn-warning btn-sm mr-1 editRole">
                                            <i class="ti-pencil"></i>
                                        </a>';
                            //}
                        }
                        /* if(auth()->user()->can('detail-role')){
                            $btn .= '<a href="'.route('panel.roles.detail',['role' => $role->id]).'" data-toggle="tooltip" data-placement="right" title="Detalles"  data-id="'.$role->id.'" id="det_'.$role->id.'" class="btn btn-info btn-sm  mr-1 detailRole">
                                        <i class="ti-search"></i>
                                    </a>';
                        } */
                        if(auth()->user()->can('delete-role')){
                            //if($role->name != 'super-admin' && $role->name != 'seller' && $role->name != 'competitor' ){
                                $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" data-placement="right" title="Eliminar"  data-url="'.route('panel.roles.destroy',['role' => $role->id]).'" class="btn btn-danger btn-sm deleteRole">
                                            <i class="ti-trash"></i>
                                        </a>';
                            //}
                        }
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('panel.roles.index', [
            'title'              => 'Roles',
            'title_header'       => 'Listado de roles',
            'description_module' => 'Informacion de los roles que se encuentran en el sistema.',
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
        return view('panel.roles.create', [
            'title'              => 'Roles',
            'title_header'       => 'Registrar role',
            'description_module' => 'Registro de roles en el sistema.',
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
    public function store(FormRoleCreateRequest $request)
    {
        $store = Role::create([
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
        $roleRole = DB::table('model_has_roles')->select('role_id')->where('model_id',  $id)->pluck('role_id')->toArray();
        return view('panel.roles.show', ['title' => 'Usuarios - Perfil', 'role' => Role::find($id), 'userRole' => $roleRole, 'roles' => Role::all(), 'permissions' => Role::findOrFail($id)->getAllPermissions()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        $roleRole = DB::table('model_has_roles')->select('role_id')->where('model_id',  $id)->pluck('role_id')->toArray();
        return view('panel.roles.detail', ['title' => 'Usuarios - Detalle', 'role' => Role::find($id), 'userRole' => $roleRole, 'roles' => Role::all(), 'permissions' => Role::findOrFail($id)->getAllPermissions()]);
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

        return view('panel.roles.edit', [
            'title'              => 'Roles',
            'title_header'       => 'Editar Role',
            'description_module' => 'Actualice la informacion del role en el formulario de Edicion.',
            'title_nav'          => 'Editar',
            'icon'               => 'icofont-settings',
            'permissions'        => Permission::all(),
            'role'               => Role::findOrFail($id),
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
    public function update(FormRoleEditRequest $request, Role $Role)
    {
        $role = Role::findOrFail($Role->id);

        $update = $role->update([
            'name'         => $request->name,
            'description'  => $request->description
        ]);
        $role->syncPermissions($request->syncPermissions, true);
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
            $role = Role::findOrFail($id);
            $delete = $role->delete();
            if ($delete) {
                return response()->json(['success' => true, 'message' => 'Jimbo panel notifica: Role eliminado exitosamente.'], 200);
            } else {
                return response()->json(['success' => true, 'message' => 'Jimbo panel notifica: El role no se elimino correctamente. Intente mas tarde.'], 200);
            }
        }
        abort(404);
    }
}
