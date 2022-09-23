<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\FormUserEditRequest;
use App\Http\Requests\FormUserCreateRequest;
use Illuminate\Support\Facades\File;


class UserController extends Controller
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
            $user = DB::table('users')->select('id',  'image', 'name AS fullname', 'email', 'active')->whereNull('deleted_at')->get();
            return Datatables::of($user)
                    ->addIndexColumn()
                    ->addColumn('action', function($user){
                           $btn = '';
                        if(auth()->user()->can('edit-user')){

                            $btn .= '<a href="'.route('panel.users.edit',['user' => $user->id]).'" data-toggle="tooltip" data-placement="right" title="Editar"  data-id="'.$user->id.'" id="edit_'.$user->id.'" class="btn btn-warning btn-sm mr-1 editUser">
                                            <i class="ti-pencil"></i>
                                    </a>';
                        }
                        if(auth()->user()->can('detail-user')){
                            $btn .= '<a href="'.route('panel.users.detail',['user' => $user->id]).'" data-toggle="tooltip" data-placement="right" title="Detalles"  data-id="'.$user->id.'" id="det_'.$user->id.'" class="btn btn-info btn-sm  mr-1 detailUser">
                                        <i class="ti-search"></i>
                                    </a>';
                        }
                        if(auth()->user()->can('delete-user')){
                            $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" data-placement="right" title="Eliminar"  data-url="'.route('panel.users.destroy',['user' => $user->id]).'" class="btn btn-danger btn-sm deleteUser">
                                            <i class="ti-trash"></i>
                                    </a>';
                        }
                        return $btn;
                    })
                    ->addColumn('active', function($user){
                        $btn = '';
                        if($user->active==1){
                            $btn .= '<span class="badge badge-success" title="Activo"><i class="ti-check"></i></span>';
                        }else{
                            $btn .= '<span class="badge badge-danger" title="Inactivo"><i class="ti-close"></i></span>';
                        }
                        return $btn;
                    })
                    ->addColumn('image', function($user){
                        $img = $user->image != 'avatar.svg' ? asset('assets/images/users/'.$user->image): asset('assets/images/avatar.svg');
                        return '<img src="'.$img.'" class="img-50 img-radius" alt="User-Profile-Image">';
                    })
                    ->addColumn('role', function($user){
                        $btn = '';
                        $user = User::find($user->id);
                        $btn .= '<span class="badge badge-inverse">'.$user->getRoleNames()->join('').'</span>';
                        return   $btn;
                    })
                    ->rawColumns(['action','active', 'role', 'image'])
                    ->make(true);
        }
        return view('panel.users.index', [
            'title'              => 'Usuarios',
            'title_header'       => 'Listado de usuarios',
            'description_module' => 'Informacion de los usuarios que se encuentran en el sistema.',
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
        return view('panel.users.create', [
            'title'              => 'Usuarios',
            'title_header'       => 'Registrar usuarios',
            'description_module' => 'Registrar nuevos usuarios en el sistema.',
            'title_nav'          => 'Registrar',
            'icon'               => 'icofont-users',
            'roles' => Role::where('name', '<>', 'seller')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FormUserCreateRequest $request)
    {
        $user                   = new User();
        $user->name             = $request->name;
        $user->email            = $request->email;
        $user->active           = $request->active;
        $user->password         = Hash::make($request->password);

        if($request->file('image')){
            $file           = $request->file('image');
            $extension      = $file->getClientOriginalExtension();
            $fileName       = time().uniqid() . '.' . $extension;
            $user->image      = $fileName;
            $file->move(public_path('assets/images/users/'), $fileName);
        }else{
            $user->image = 'avatar.svg';
        }

        $saved = $user->save();
        if($saved)
        $user->assignRole($request->role);
            return response()->json(['success' => true, 'message' => 'Jimbo panel notifica: Usuario registrado exitosamente.'], 200);
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
        $userRole = DB::table('model_has_roles')->select('role_id')->where('model_id',  $id)->pluck('role_id')->toArray();
        return view('panel.users.show', ['title' => 'Usuarios - Perfil', 'user' => User::find($id), 'userRole' => $userRole, 'roles' => Role::all(), 'permissions' => User::findOrFail($id)->getAllPermissions()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        $userRole = DB::table('model_has_roles')->select('role_id')->where('model_id',  $id)->pluck('role_id')->toArray();
        return view('panel.users.detail', ['title' => 'Usuarios - Detalle', 'user' => User::find($id), 'userRole' => $userRole, 'roles' => Role::all(), 'permissions' => User::findOrFail($id)->getAllPermissions()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $userRole = DB::table('model_has_roles')->select('role_id')->where('model_id',  $id)->pluck('role_id')->toArray();
        return view('panel.users.edit', [
            'title'              => 'Usuarios',
            'title_header'       => 'Editar usuarios',
            'description_module' => 'Actualice la informacion del usuario en el formulario de Edicion.',
            'title_nav'          => 'Editar',
            'icon'               => 'icofont-users',
            'user' => User::find($id), 'userRole' => $userRole,
            'roles' => Role::where('name', '<>', 'seller')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FormUserEditRequest $request, User $User)
    {
        $user                   = User::find($User->id);
        $user->name             = $request->name;
        $user->email            = $request->email;
        $user->active           = $request->active==1 ? 1 : 0;
        if($request->password){
            $user->password     = Hash::make($request->password);
        }

        if($request->file('image')){
            if ($user->image != "avatar.svg") {
                if (File::exists(public_path('assets/images/users/' . $user->image))) {
                    File::delete(public_path('assets/images/users/' . $user->image));
                }
            }

            $file           = $request->file('image');
            $extension      = $file->getClientOriginalExtension();
            $fileName       = time() . '.' . $extension;
            $user->image      = $fileName;
            $file->move(public_path('assets/images/users/'), $fileName);
        }
        $saved = $user->save();
        if($saved)
            $user->syncRoles($request->role);
            return response()->json(['success' => true, 'message' => 'Jimbo panel notifica: Usuario actualizado exitosamente.'], 200);
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
            $user = User::findOrFail($id);
            /* if ($user->image != "avatar.svg") {
                if (File::exists(public_path('assets/images/users/' . $user->image))) {
                    File::delete(public_path('assets/images/users/' . $user->image));
                }
            } */
            $delete = $user->delete();
            if ($delete) {
                return response()->json(['success' => true, 'message' => 'Jimbo panel notifica: Usuario eliminado exitosamente.'], 200);
            } else {
                return response()->json(['success' => true, 'message' => 'Jimbo panel notifica: El usuario no se elimino correctamente. Intente mas tarde.'], 200);
            }
        }
        abort(404);
    }
}
