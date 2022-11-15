<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\FormPromotionRequest;
use App\Models\Promotion;
use DataTables;


class PromotionController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $promotion = DB::table('promotions')->select('id', 'name', 'code', 'price', 'quantity', 'active')->whereNull('deleted_at')->get();
                return Datatables::of($promotion)
                    ->addIndexColumn()
                    ->addColumn('action', function($promotion){
                           $btn = '';
                        if(auth()->user()->can('edit-promotion')){
                            $btn .= '<a href="'.route('panel.promotions.edit',['promotion' => $promotion->id]).'" data-toggle="tooltip" data-placement="right" title="Editar"  data-id="'.$promotion->id.'" id="edit_'.$promotion->id.'" class="btn btn-warning btn-sm mr-1 editPromotion">
                                        <i class="ti-pencil"></i>
                                    </a>';
                        }
                        if(auth()->user()->can('delete-promotion')){
                            $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" data-placement="right" title="Eliminar"  data-url="'.route('panel.promotions.destroy',['promotion' => $promotion->id]).'" class="btn btn-danger btn-sm deletePromotion">
                                        <i class="ti-trash"></i>
                                    </a>';
                        }
                        return $btn;
                    })->addColumn('active', function($promotion){
                        $btn = '';
                        if($promotion->active==1){
                            $btn .= '<span class="badge badge-success" title="Activa"><i class="ti-check"></i></span>';
                        }else{
                            $btn .= '<span class="badge badge-danger" title="Inactiva"><i class="ti-close"></i></span>';
                        }
                        return $btn;
                    })->addColumn('price', function($promotion){

                        return Helper::amount($promotion->price);
                    })
                    ->rawColumns(['action','active','price'])
                    ->make(true);
        }

        return view('panel.promotions.index', [
            'title'              => 'Promociones',
            'title_header'       => 'Listado de promociones',
            'description_module' => 'Informacion de las promociones que se encuentran en el sistema.',
            'title_nav'          => 'Listado',
            'icon'               => 'icofont-megaphone'
        ]);
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('panel.promotions.create', [
            'title'              => 'Promociones',
            'title_header'       => 'Registrar promocion',
            'description_module' => 'Registro de promocion en el sistema.',
            'title_nav'          => 'Registrar',
            'icon'               => 'icofont-megaphone',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FormPromotionRequest $request)
    {
        $promotion                   = new Promotion();
        $promotion->name             = $request->name;
        $promotion->price            = $request->price;
        $promotion->code             = $request->code;
        $promotion->active           = $request->active;
        $promotion->quantity         = $request->quantity;
        $saved = $promotion->save();

        if($saved)
            return response()->json(['success' => true, 'message' => 'Jimbo panel notifica: Promocion registrada exitosamente.'], 200);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('panel.promotions.edit', [
            'title'              => 'Promociones',
            'title_header'       => 'Editar promocion',
            'description_module' => 'Actualice la informacion de la promocion en el formulario de Edicion.',
            'title_nav'          => 'Editar',
            'icon'               => 'icofont-megaphone',
            'promotion'          => Promotion::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FormPromotionRequest $request, $id)
    {
        $promotion                   = Promotion::find($id);
        $promotion->name             = $request->name;
        $promotion->price            = $request->price;
        $promotion->quantity         = $request->quantity;
        $promotion->code             = $request->code;
        $promotion->active  = $request->active==1 ? 1 : 0;
        $saved = $promotion->save();

        if($saved)
            return response()->json(['success' => true, 'message' => 'Jimbo panel notifica: Promocion actualizada exitosamente.'], 200);
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
            $promotion = Promotion::findOrFail($id);
            if($promotion->Tickets->count()>0){
                return response()->json(['success' => false, 'message' => 'Jimbo panel notifica: Promocion de boleto, no se puede eliminar, porque pertence a un sorteo.'], 200);
            }
            $delete = $promotion->delete();
            if ($delete) {
                return response()->json(['success' => true, 'message' => 'Jimbo panel notifica: Promocion de boleto eliminada exitosamente.'], 200);
            } else {
                return response()->json(['success' => false, 'message' => 'Jimbo panel notifica: La promocion de boleto no se elimino correctamente. Intente mas tarde.'], 200);
            }
        }
        abort(404);
    }
}
