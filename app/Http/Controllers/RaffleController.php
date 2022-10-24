<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\FormRaffleRequest;
use App\Models\Raffle;
use App\Models\Promotion;
use App\Models\Ticket;
use DataTables;


class RaffleController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $raffle = Raffle::select(
                                    'id',
                                    'title',
                                    DB::raw("CONCAT(cash_to_draw,'$') AS cash_to_draw"),
                                    DB::raw("CONCAT(cash_to_collect,'$') AS cash_to_collect"),
                                    'date_start',
                                    'date_end',
                                    'date_release',
                                    'public',
                                    'active')
                                    ->whereNull('deleted_at')->get();
                return Datatables::of($raffle)
                    ->addIndexColumn()
                    ->addColumn('action', function($raffle){
                           $btn = '';
                        if(auth()->user()->can('show-raffle')){
                            $btn .= '<a href="'.route('panel.raffles.show',['raffle' => $raffle->id]).'" data-toggle="tooltip" data-placement="right" title="Detalles"  data-id="'.$raffle->id.'" id="show_'.$raffle->id.'" class="btn btn-dark btn-sm mr-1 showRaffle">
                                        <i class="ti-eye"></i>
                                    </a>';
                        }
                        if(auth()->user()->can('edit-raffle')){
                            $btn .= '<a href="'.route('panel.raffles.edit',['raffle' => $raffle->id]).'" data-toggle="tooltip" data-placement="right" title="Editar"  data-id="'.$raffle->id.'" id="edit_'.$raffle->id.'" class="btn btn-warning btn-sm mr-1 editRaffle">
                                        <i class="ti-pencil"></i>
                                    </a>';
                        }
                        if(auth()->user()->can('delete-raffle')){
                            $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" data-placement="right" title="Eliminar"  data-url="'.route('panel.raffles.destroy',['raffle' => $raffle->id]).'" class="btn btn-danger btn-sm deleteRaffle">
                                        <i class="ti-trash"></i>
                                    </a>';
                        }
                        return $btn;
                    })->addColumn('active', function($raffle){
                        $btn = '';
                        if($raffle->active==1){
                            $btn .= '<span class="badge badge-success" title="Activo"><i class="ti-check"></i></span>';
                        }else{
                            $btn .= '<span class="badge badge-danger" title="Inactivo"><i class="ti-close"></i></span>';
                        }
                        return $btn;
                    })->addColumn('public', function($raffle){
                        $btn = '';
                        if($raffle->public==1){
                            $btn .= '<span class="badge badge-success" title="Publicado">Publico</span>';
                        }else{
                            $btn .= '<span class="badge badge-danger" title="Borrador">Borrador</span>';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action','active', 'public'])
                    ->make(true);
        }

        return $balance = DB::table('balance_histories')->select(
            'balance_histories.id',
            'balance_histories.reference',
            'balance_histories.description',
            'balance_histories.type',
            'balance_histories.currency',
            'balance_histories.balance',
            'balance_histories.date',
            'balance_histories.hour',
            )
            ->join('users', 'users.id', '=', 'balance_histories.user_id')
            ->where('users.id', 12)
            ->get();



        return view('panel.raffles.index', [
            'title'              => 'Sorteos',
            'title_header'       => 'Listado de sorteos',
            'description_module' => 'Informacion de los sorteos que se encuentran en el sistema.',
            'title_nav'          => 'Listado',
            'icon'               => 'icofont-gift'
        ]);
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('panel.raffles.create', [
            'title'              => 'Sorteos',
            'title_header'       => 'Registrar sorteo',
            'description_module' => 'Registro de sorteo en el sistema.',
            'title_nav'          => 'Registrar',
            'icon'               => 'icofont-gift',
            'promotions'         => Promotion::where('active', 1)->whereNull('deleted_at')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FormRaffleRequest $request)
    {
        $raffle                   = new Raffle();
        $raffle->title            = $request->title;
        $raffle->description      = $request->description;
        $raffle->brand            = $request->brand;
        $raffle->promoter         = $request->promoter;
        $raffle->place            = $request->place;
        $raffle->provider         = $request->provider;
        $raffle->cash_to_draw     = $request->cash_to_draw;
        $raffle->cash_to_collect  = $request->cash_to_collect;
        $raffle->public           = $request->public;
        $raffle->active           = $request->active;
        $raffle->prize_1          = $request->prize_1;
        $raffle->prize_2          = $request->prize_2;
        $raffle->prize_3          = $request->prize_3;
        $raffle->prize_4          = $request->prize_4;
        $raffle->prize_5          = $request->prize_5;
        $raffle->prize_6          = $request->prize_6;
        $raffle->prize_7          = $request->prize_7;
        $raffle->prize_8          = $request->prize_8;
        $raffle->prize_9          = $request->prize_9;
        $raffle->prize_10         = $request->prize_10;
        $raffle->date_start       = $request->date_start;
        $raffle->date_end         = $request->date_end;
        $raffle->date_release     = $request->date_release;
        $raffle->draft_at         = $request->public == 0 ? now() : null;

        if($request->file('image')){
            $file           = $request->file('image');
            $extension      = $file->getClientOriginalExtension();
            $fileName       = time().uniqid() . '.' . $extension;
            $raffle->image   = $fileName;
            $file->move(public_path('assets/images/raffles/'), $fileName);
        }else{
            $raffle->image = 'raffle.jpg';
        }
        $saved = $raffle->save();

        if($saved){
            $promotions = [];
            foreach (json_decode($request->promotions_raffle) as $promotion) {
                $data = array(
                    'serial'         => (int)$promotion->id.uniqid().$raffle->id,
                    'raffle_id'      => (int)$raffle->id,
                    'promotion_id'   => (int)$promotion->id,
                    'quantity'       => (int)$promotion->ticket,
                    'total'          => (int)$promotion->ticket
                );
                array_push($promotions, $data);
            }
            $raffle->Tickets()->insert($promotions);

            return response()->json(['success' => true, 'message' => 'Jimbo panel notifica: sorteo registrado exitosamente.'], 200);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('panel.raffles.show', [
            'title'              => 'Sorteos',
            'title_header'       => 'Detalles sorteo - '.Raffle::findOrFail($id)->title,
            'description_module' => 'Informacion del sorteo en el sistema.',
            'title_nav'          => 'Detalles',
            'icon'               => 'icofont-gift',
            'raffle'             => Raffle::findOrFail($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('panel.raffles.edit', [
            'title'              => 'Sorteos',
            'title_header'       => 'Editar sorteo',
            'description_module' => 'Actualice la informacion del sorteo en el formulario de Edicion.',
            'title_nav'          => 'Editar',
            'icon'               => 'icofont-gift',
            'raffle'             => Raffle::findOrFail($id),
            'promotions'         => Promotion::where('active', 1)->whereNull('deleted_at')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FormRaffleRequest $request, Raffle $Raffle)
    {
        $raffle                   = Raffle::find($Raffle->id);
        $raffle->title            = $request->title;
        $raffle->description      = $request->description;
        $raffle->brand            = $request->brand;
        $raffle->promoter         = $request->promoter;
        $raffle->place            = $request->place;
        $raffle->provider         = $request->provider;
        $raffle->cash_to_draw     = $request->cash_to_draw;
        $raffle->cash_to_collect  = $request->cash_to_collect;
        $raffle->public           = $request->public == 1 ? 1 : 0;
        $raffle->active           = $request->active == 1 ? 1 : 0;
        $raffle->prize_1          = $request->prize_1;
        $raffle->prize_2          = $request->prize_2;
        $raffle->prize_3          = $request->prize_3;
        $raffle->prize_4          = $request->prize_4;
        $raffle->prize_5          = $request->prize_5;
        $raffle->prize_6          = $request->prize_6;
        $raffle->prize_7          = $request->prize_7;
        $raffle->prize_8          = $request->prize_8;
        $raffle->prize_9          = $request->prize_9;
        $raffle->prize_10         = $request->prize_10;
        $raffle->date_start       = $request->date_start;
        $raffle->date_end         = $request->date_end;
        $raffle->date_release     = $request->date_release;
        $raffle->draft_at         = $request->public == 0 ? now() : null;

        if($request->file('image')){
            if ($raffle->image != "raffle.jpg") {
                if (File::exists(public_path('assets/images/raffles/' . $raffle->image))) {
                    File::delete(public_path('assets/images/raffles/' . $raffle->image));
                }
            }

            $file           = $request->file('image');
            $extension      = $file->getClientOriginalExtension();
            $fileName       = time() . '.' . $extension;
            $raffle->image      = $fileName;
            $file->move(public_path('assets/images/raffles/'), $fileName);
        }

        $saved = $raffle->save();

        if($saved){
            return response()->json(['success' => true, 'message' => 'Jimbo panel notifica: Sorteo actualizado exitosamente.'], 200);
        }
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
            $raffle = Raffle::findOrFail($id);

            $delete = $raffle->delete();
            if ($delete) {
                return response()->json(['success' => true, 'message' => 'Jimbo panel notifica: Sorteo eliminado exitosamente.'], 200);
            } else {
                return response()->json(['success' => false, 'message' => 'Jimbo panel notifica: El sorteo no se elimino correctamente. Intente mas tarde.'], 200);
            }
        }
        abort(404);
    }

    public function promotions(Request $request)
    {
        if(\Request::wantsJson()){
            $raffle = Raffle::findOrFail($request->id);
            $promotions = [];

            foreach ($raffle->tickets as $key => $ticket) {

                array_push( $promotions, [
                    'id'        => $ticket->id,
                    'quantity'  => $ticket->quantity,
                    'total'     => $ticket->total,
                    'serial'    => $ticket->serial,
                    'promotion' => $ticket->promotion,
                ]);
            }
            return response()->json(['success' => true, 'promotions' => $promotions], 200);
        }
        abort(404);
    }

    public function promotionAdd(Request $request)
    {
        if(\Request::wantsJson()){

            $raffle = Raffle::findOrFail($request->raffle_id);
            $promotion = Promotion::findOrFail($request->promotion_id);
            $ticket = Ticket::where('promotion_id', $promotion->id)->first();

            if($request->quantity> 0 && ($request->quantity % $promotion->quantity) !=0) {
                return response()->json(['success' => false, 'message' => 'Jimbo panel notifica: La cantidad de boletos debe ser multiplo de '.$promotion->quantity.' para la promocion '.$promotion->name], 200);
            }elseif($ticket) {
                return response()->json(['success' => false, 'message' => 'Jimbo panel notifica: La promocion del sorteo ya esta configurada.'], 200);
            }

            $promotions = [
                'serial'         => (string)$promotion->code,
                'raffle_id'      => (int)$raffle->id,
                'promotion_id'   => (int)$promotion->id,
                'quantity'       => (int)$request->quantity,
                'total'          => (int)$request->quantity
            ];
            $save = $raffle->Tickets()->insert($promotions);

            if($save) {
                return response()->json(['success' => true, 'message' => 'Jimbo panel notifica: Promocion del sorteo configurado exitosamente.'], 200);
            } else{
                return response()->json(['success' => true, 'message' => 'Jimbo panel notifica: La promocion para el sorteo no pudo ser configurada.'], 200);
            }
        }
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function promotionDelete(Request $request)
    {
        if(\Request::wantsJson()){
            $ticket = Ticket::findOrFail($request->id);

            $delete = $ticket->delete();
            if ($delete) {
                return response()->json(['success' => true, 'message' => 'Jimbo panel notifica: Promocion eliminada exitosamente.'], 200);
            } else {
                return response()->json(['success' => false, 'message' => 'Jimbo panel notifica: La promocion sorteo no se elimino correctamente. Intente mas tarde.'], 200);
            }
        }
        abort(404);
    }
}
