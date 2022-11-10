<?php

namespace App\Http\Controllers;

use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Action;
use App\Models\User;
use Illuminate\Support\Carbon;

class ActionController extends Controller
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
            $action = Action::select(
                'id',
                'title',
                'description',
                'user_id',
                'created_at AS date',
            )->get();
            return Datatables::of($action)
                    ->addIndexColumn()
                    ->addColumn('action', function($action){
                    })
                    ->addColumn('date', function($action){
                        $date = Carbon::parse($action->date)->format('d/m/Y H:i:s');
                        return   $date;
                    })
                    ->addColumn('user', function($action){
                        $user = User::find($action->user_id);
                        $user = $user ? $user->email : null;
                        return   $user;
                    })
                    ->rawColumns(['action','date', 'user'])
                    ->make(true);
        }
        return view('panel.actions.index', [
            'title'              => 'Acciones',
            'title_header'       => 'Listado de acciones en el Panel y App Jimbo',
            'description_module' => 'Informacion de las diferentes acciones que se registran en el sistema.',
            'title_nav'          => 'Listado',
            'icon'               => 'icofont-listing-number'
        ]);
    }
}
