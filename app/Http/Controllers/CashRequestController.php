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
use App\Http\Requests\FormChangeStatuRequest;

class CashRequestController extends Controller
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
            $cash = CashRequest::select(
                'id',
                'amount',
                'date',
                'hour',
                'reference',
                'description',
                'status',
                'user_id'
            )->where('status', '<>', 'approved')->get();
            return Datatables::of($cash)
                    ->addIndexColumn()
                    ->addColumn('action', function($cash){
                           $btn = '';

                        if(auth()->user()->can('show-cash-request')){
                            $btn .= '<a href="'.route('panel.cash.request.show',['id' => $cash->id]).'" data-toggle="tooltip" data-placement="right" title="Detalles"  data-id="'.$cash->id.'" id="det_'.$cash->id.'" class="btn btn-warning btn-sm  mr-1 detailCashRequest">
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
        return view('panel.cash _requests.index', [
            'title'              => 'Solicitudes de Efectivo',
            'title_header'       => 'Listado de Solicitudes',
            'description_module' => 'Informacion de las solicitudes de efectvo que se encuentran en el sistema.',
            'title_nav'          => 'Listado',
            'icon'               => 'icofont icofont-bill-alt'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $status = [
                'approved'  => 'Aprobada',
                'refused'   => 'Rechazada',
                'pending'   => 'Pendiente',
                'return'    => 'Regresada',
                'created'   => 'Creada',
        ];
        return view('panel.cash _requests.show', [
            'title'              => 'Solicitudes de Efectivo',
            'title_header'       => 'Detalles de la solicitud',
            'description_module' => 'Informacion de la solicitud de efectivo en el sistema.',
            'title_nav'          => 'Detalles',
            'cash'               => CashRequest::findOrFail($id),
            'icon'               => 'icofont icofont-bill-alt',
            'status'             => $status
        ]);
    }

    /**
     * Change status
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changeStatu(FormChangeStatuRequest $request, $id)
    {
        $cash = CashRequest::find($id);
        $cash->status       =  $request->status;
        $cash->observation  =  $request->observation;
        if($cash->save()){
            return response()->json(['success' => true, 'message' => 'Jimbo panel notifica: Estado de la solicitud actualizada exitosamente.'], 200);
        }
        return response()->json(['success' => false, 'message' => 'Jimbo panel notifica: Estado de la solicitud no se procactualizo exitosamente.'], 200);
    }
}
