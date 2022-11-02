<?php

namespace App\Http\Controllers;

use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\CashRequest;
use App\Helpers\Helper;
use App\Models\User;

class EgressController extends Controller
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
        return view('panel.egress.index', [
            'title'              => 'Egresos',
            'title_header'       => 'Listado de Egresos',
            'description_module' => 'Informacion de los diferentes egresos en el sistema.',
            'title_nav'          => 'Listado',
            'icon'               => 'icofont icofont-money'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cash(Request $request)
    {
        if ($request->ajax()) {
            $cash = CashRequest::select(
                'id',
                'amount',
                'date',
                'hour',
                'reference',
                'description',
                'status',
                'user_id'
            )->where('status', 'approved')->get();
            return Datatables::of($cash)
                    ->addIndexColumn()
                    ->addColumn('action', function($cash){
                           $btn = '';

                        if(auth()->user()->can('show-egress')){
                            $btn .= '<a href="'.route('panel.egress.show',['id' => $cash->id]).'" data-toggle="tooltip" data-placement="right" title="Detalles"  data-id="'.$cash->id.'" id="det_'.$cash->id.'" class="btn btn-warning btn-sm  mr-1 detailCashRequest">
                                        <i class="ti-eye"></i>
                                    </a>';
                        }
                        return $btn;
                    })->addColumn('amount', function($cash){
                        return   Helper::amount($cash->amount);
                    })->addColumn('date', function($cash){
                        $cash = CashRequest::find($cash->id);
                        $date = explode('-', $cash->date);
                        return $date[2].'/'.$date[1].'/'.$date[0];
                    })->addColumn('user', function($cash){
                        $user = User::find($cash->user_id);
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
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function jib(Request $request)
    {
        if ($request->ajax()) {
            $cash = CashRequest::select(
                'id',
                'amount',
                'date',
                'hour',
                'reference',
                'description',
                'status',
                'user_id'
            )->where('status', 'approved')->get();
            return Datatables::of($cash)
                    ->addIndexColumn()
                    ->addColumn('action', function($cash){
                           $btn = '';

                        if(auth()->user()->can('show-cash')){
                            $btn .= '<a href="'.route('panel.cash.request.show',['id' => $cash->id]).'" data-toggle="tooltip" data-placement="right" title="Detalles"  data-id="'.$cash->id.'" id="det_'.$cash->id.'" class="btn btn-warning btn-sm  mr-1 detailCashRequest">
                                        <i class="ti-eye"></i>
                                    </a>';
                        }
                        $btn .= '<a href="'.route('panel.cash.request.show',['id' => $cash->id]).'" data-toggle="tooltip" data-placement="right" title="Detalles"  data-id="'.$cash->id.'" id="det_'.$cash->id.'" class="btn btn-warning btn-sm  mr-1 detailCashRequest">
                                        <i class="ti-eye"></i>
                                    </a>';
                        return $btn;
                    })->addColumn('amount', function($cash){
                        return   Helper::amount($cash->amount);
                    })->addColumn('date', function($cash){
                        $cash = CashRequest::find($cash->id);
                        $date = explode('-', $cash->date);
                        return $date[2].'/'.$date[1].'/'.$date[0];
                    })->addColumn('user', function($cash){
                        $user = User::find($cash->user_id);
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
        }
        return view('panel.cash _requests.index', [
            'title'              => 'Solicitudes de Efectivo',
            'title_header'       => 'Listado de Solicitudes',
            'description_module' => 'Informacion de las solicitudes de efectvo que se encuentran en el sistema.',
            'title_nav'          => 'Listado',
            'icon'               => 'icofont icofont-bill-alt'
        ]);
    }


    public function show ($id)
    {
        return view('panel.egress.show', [
            'title'              => 'Egresos de Efectivo',
            'title_header'       => 'Egreso detalles',
            'description_module' => 'Informacion del egreso de efectivo en el sistema.',
            'title_nav'          => 'Detalles',
            'egress'             => CashRequest::findOrFail($id),
            'icon'               => 'icofont icofont-money'
        ]);
    }
}
