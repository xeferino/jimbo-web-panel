<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\FormSliderRequest;
use Illuminate\Support\Facades\File;
use App\Models\Slider;
use DataTables;


class SliderController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $slider = DB::table('sliders')->select('id', 'name', 'image', 'active')->whereNull('deleted_at')->get();
                return Datatables::of($slider)
                    ->addIndexColumn()
                    ->addColumn('action', function($slider){
                           $btn = '';
                        if(auth()->user()->can('edit-slider')){
                            $btn .= '<a href="'.route('panel.sliders.edit',['slider' => $slider->id]).'" data-toggle="tooltip" data-placement="right" title="Editar"  data-id="'.$slider->id.'" id="edit_'.$slider->id.'" class="btn btn-warning btn-sm mr-1 editSlider">
                                        <i class="ti-pencil"></i>
                                    </a>';
                        }
                        if(auth()->user()->can('delete-slider')){
                            $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" data-placement="right" title="Eliminar"  data-url="'.route('panel.sliders.destroy',['slider' => $slider->id]).'" class="btn btn-danger btn-sm deleteSlider">
                                        <i class="ti-trash"></i>
                                    </a>';
                        }
                        return $btn;
                    })->addColumn('active', function($slider){
                        $btn = '';
                        if($slider->active==1){
                            $btn .= '<span class="badge badge-success" title="Activa"><i class="ti-check"></i></span>';
                        }else{
                            $btn .= '<span class="badge badge-danger" title="Inactiva"><i class="ti-close"></i></span>';
                        }
                        return $btn;
                    })->addColumn('image', function($slider){
                        $img = $slider->image != 'slider.png' ? asset('assets/images/sliders/'.$slider->image): asset('assets/images/sliders/slider.png');
                        return '<img src="'.$img.'" class="img-50" alt="slider">';
                    })
                    ->rawColumns(['action','active', 'image'])
                    ->make(true);
        }

        return view('panel.sliders.index', [
            'title'              => 'Sliders',
            'title_header'       => 'Listado de sliders',
            'description_module' => 'Informacion de las sliders que se encuentran en el sistema.',
            'title_nav'          => 'Listado',
            'icon'               => 'icofont-image'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('panel.sliders.create', [
            'title'              => 'Sliders',
            'title_header'       => 'Registrar Slider',
            'description_module' => 'Registro de sliders en el sistema.',
            'title_nav'          => 'Registrar',
            'icon'               => 'icofont-image',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FormSliderRequest $request, Slider $slider)
    {
        $slider                   = new Slider();
        $slider->name             = $request->name;
        $slider->active           = $request->active;

        if($request->file('image')){
            $file           = $request->file('image');
            $extension      = $file->getClientOriginalExtension();
            $fileName       = time().uniqid() . '.' . $extension;
            $slider->image   = $fileName;
            $file->move(public_path('assets/images/sliders/'), $fileName);
        }else{
            $slider->image = 'slider.png';
        }

        $saved = $slider->save();
        if($saved)
            return response()->json(['success' => true, 'message' => 'Jimbo panel notifica: Slider registrado exitosamente.'], 200);
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
        return view('panel.sliders.edit', [
            'title'              => 'Sliders',
            'title_header'       => 'Editar Slider',
            'description_module' => 'Actualice la informacion del slider en el formulario de Edicion.',
            'title_nav'          => 'Editar',
            'icon'               => 'icofont-image',
            'slider'             => Slider::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FormSliderRequest $request, Slider $Slider)
    {
        $slider = Slider::findOrFail($Slider->id);

        $slider->name    = $request->name;
        $slider->active  = $request->active==1 ? 1 : 0;

        if($request->file('image')){
            if ($slider->image != "slider.png") {
                if (File::exists(public_path('assets/images/sliders/' . $slider->image))) {
                    File::delete(public_path('assets/images/sliders/' . $slider->image));
                }
            }

            $file           = $request->file('image');
            $extension      = $file->getClientOriginalExtension();
            $fileName       = time() . '.' . $extension;
            $slider->image      = $fileName;
            $file->move(public_path('assets/images/sliders/'), $fileName);
        }

        $update = $slider->save();

        if($update)
            return response()->json(['success' => true, 'message' => 'Jimbo panel notifica: Slider actualizado exitosamente.'], 200);
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
            $slider = Slider::findOrFail($id);
            /* if ($slider->image != "slider.png") {
                if (File::exists(public_path('assets/images/sliders/' . $slider->image))) {
                    File::delete(public_path('assets/images/sliders/' . $slider->image));
                }
            } */
            $delete = $slider->delete();
            if ($delete) {
                return response()->json(['success' => true, 'message' => 'Jimbo panel notifica: slider eliminado exitosamente.'], 200);
            } else {
                return response()->json(['success' => true, 'message' => 'Jimbo panel notifica: El slider no se elimino correctamente. Intente mas tarde.'], 200);
            }
        }
        abort(404);
    }
}
