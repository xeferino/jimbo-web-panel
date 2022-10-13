<?php

namespace App\Http\Controllers;

use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Country;
use App\Http\Requests\FormCountryEditRequest;
use App\Http\Requests\FormCountryCreateRequest;
use Illuminate\Support\Facades\File;


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
            $country = DB::table('countries')->select('id', 'name', 'code', 'img', 'active', 'currency', 'exchange_rate')->whereNull('deleted_at')->get();
            return Datatables::of($country)
                    ->addIndexColumn()
                    ->addColumn('action', function($country){
                           $btn = '';
                        if(auth()->user()->can('edit-country')){
                            $btn .= '<a href="'.route('panel.countries.edit',['country' => $country->id]).'" data-toggle="tooltip" data-placement="right" title="Editar"  data-id="'.$country->id.'" id="edit_'.$country->id.'" class="btn btn-warning btn-sm mr-1 editCountry">
                                            <i class="ti-pencil"></i>
                                        </a>';
                        }

                        if(auth()->user()->can('delete-country')){
                            $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" data-placement="right" title="Eliminar"  data-url="'.route('panel.countries.destroy',['country' => $country->id]).'" class="btn btn-danger btn-sm deleteCountry">
                                        <i class="ti-trash"></i>
                                    </a>';
                        }
                        return $btn;
                    })->addColumn('active', function($country){
                        $btn = '';
                        if($country->active==1){
                            $btn .= '<span class="badge badge-success" title="Activo"><i class="ti-check"></i></span>';
                        }else{
                            $btn .= '<span class="badge badge-danger" title="Inactivo"><i class="ti-close"></i></span>';
                        }
                        return $btn;
                    })
                    ->addColumn('img', function($country){
                        $img = $country->img != 'flag.png' ? asset('assets/images/flags/'.$country->img): asset('assets/images/flags/flag.png');
                        return '<img src="'.$img.'" class="img-50" alt="country">';
                    })
                    ->rawColumns(['action', 'img', 'active'])
                    ->make(true);
        }
        return view('panel.countries.index', [
            'title'              => 'Paises',
            'title_header'       => 'Listado de paises',
            'description_module' => 'Informacion de los paises que se encuentran en el sistema.',
            'title_nav'          => 'Listado',
            'icon'               => 'icofont-flag'
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
            'title'              => 'Paises',
            'title_header'       => 'Registrar Pais',
            'description_module' => 'Registro de paises en el sistema.',
            'title_nav'          => 'Registrar',
            'icon'               => 'icofont-flag',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FormCountryCreateRequest $request, Country $country)
    {
        $country                   = new Country();
        $country->name             = $request->name;
        $country->code             = $request->code;
        $country->active           = $request->active;
        $country->currency         = $request->currency;
        $country->exchange_rate    = $request->exchange_rate;

        if($request->file('img')){
            $file           = $request->file('img');
            $extension      = $file->getClientOriginalExtension();
            $fileName       = time().uniqid() . '.' . $extension;
            $country->img   = $fileName;
            $file->move(public_path('assets/images/flags/'), $fileName);
        }else{
            $country->img = 'flag.png';
        }

        $saved = $country->save();
        if($saved)
            return response()->json(['success' => true, 'message' => 'Jimbo panel notifica: Pais registrado exitosamente.'], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('panel.countries.edit', [
            'title'              => 'Paises',
            'title_header'       => 'Editar Pais',
            'description_module' => 'Actualice la informacion del pais en el formulario de Edicion.',
            'title_nav'          => 'Editar',
            'icon'               => 'icofont-flag',
            'country'            => Country::findOrFail($id)
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

        $country->name          = $request->name;
        $country->code          = $request->code;
        $country->active        = $request->active==1 ? 1 : 0;
        $country->currency      = $request->currency;
        $country->exchange_rate = $request->exchange_rate;

        if($request->file('img')){
            if ($country->img != "flag.png") {
                if (File::exists(public_path('assets/images/flags/' . $country->img))) {
                    File::delete(public_path('assets/images/flags/' . $country->img));
                }
            }

            $file           = $request->file('img');
            $extension      = $file->getClientOriginalExtension();
            $fileName       = time() . '.' . $extension;
            $country->img      = $fileName;
            $file->move(public_path('assets/images/flags/'), $fileName);
        }

        $update = $country->save();

        if($update)
            return response()->json(['success' => true, 'message' => 'Jimbo panel notifica: Pais actualizado exitosamente.'], 200);
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
            /* if ($country->image != "avatar.svg") {
                if (File::exists(public_path('assets/images/flags/' . $country->img))) {
                    File::delete(public_path('assets/images/flags/' . $country->img));
                }
            } */
            $delete = $country->delete();
            if ($delete) {
                return response()->json(['success' => true, 'message' => 'Jimbo panel notifica: Pais eliminado exitosamente.'], 200);
            } else {
                return response()->json(['success' => true, 'message' => 'Jimbo panel notifica: El pais no se elimino correctamente. Intente mas tarde.'], 200);
            }
        }
        abort(404);
    }
}
