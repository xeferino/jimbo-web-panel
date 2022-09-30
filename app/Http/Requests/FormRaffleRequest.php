<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormRaffleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

     /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'             => 'required|min:3',
            'description'       => 'required|min:10',
            'brand'             => 'required|min:3',
            'promoter'          => 'required|min:3',
            'place'             => 'required|min:3',
            'provider'          => 'required|min:3',
            'cash_to_draw'      => 'required|integer',
            'cash_to_collect'   => 'required|integer',
            'public'            => 'required',
            'active'            => 'required',
            'prize_1'           => 'required',
            'prize_2'           => 'required',
            'prize_3'           => 'required',
            'prize_4'           => 'required',
            'prize_5'           => 'required',
            'prize_6'           => 'required',
            'prize_7'           => 'required',
            'prize_8'           => 'required',
            'prize_9'           => 'required',
            'prize_10'          => 'required',
            'date_start'        => 'required|date',
            'date_end'          => 'required|date|after_or_equal:date_start',
            'image'             => $this->hasFile('image') ? 'required|sometimes|mimes:jpeg,jpg,png,svg|max:512|dimensions:width=400,height=200' : 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'title.required'            => 'El nombre es requerido.',
            'title.min'                 => 'El nombre es requiere minimo :min caracteres.',
            'description.required'      => 'La descripcion es requerida.',
            'description.min'           => 'La descripcion requiere minimo :min caracteres.',
            'brand.required'            => 'La marca es requerido.',
            'brand.min'                 => 'La marca es requiere minimo :min caracteres.',
            'promoter.required'         => 'El promotor es requerido.',
            'promoter.min'              => 'El promotor es requiere minimo :min caracteres.',
            'place.required'            => 'La localidad es requerido.',
            'place.min'                 => 'La localidad es requiere minimo :min caracteres.',
            'provider.required'         => 'El proveedor es requerido.',
            'provider.min'              => 'El proveedor es requiere minimo :min caracteres.',
            'cash_to_draw.required'     => 'El premio en efectivo es requerido.',
            'cash_to_draw.integer'      => 'El premio en efectivo debe ser entero.',
            'cash_to_collect.required'  => 'El dinero a recaudar es requerido.',
            'cash_to_collect.integer'   => 'El dinero a recaudar debe ser entero.',
            'public.required'           => 'La visibilidad es requerida.',
            'active.required'           => 'El estatus es requerido.',
            'prize_1.required'          => 'El porcentaje es requerido.',
            'prize_2.required'          => 'El porcentaje es requerido.',
            'prize_3.required'          => 'El porcentaje es requerido.',
            'prize_4.required'          => 'El porcentaje es requerido.',
            'prize_5.required'          => 'El porcentaje es requerido.',
            'prize_6.required'          => 'El porcentaje es requerido.',
            'prize_7.required'          => 'El porcentaje es requerido.',
            'prize_8.required'          => 'El porcentaje es requerido.',
            'prize_9.required'          => 'El porcentaje es requerido.',
            'prize_10.required'         => 'El porcentaje es requerido.',
            'date_start.required'       => 'La fecha de apertura es requerida.',
            'date_start.date'           => 'La fecha de apertura no es valida.',
            'date_end.required'         => 'La fecha de cierre es requerida.',
            'date_end.date'             => 'La fecha  de cierre no es valida.',
            'date_end.after_or_equal'   => 'La fecha  de cierre no puede ser menor a la fecha de apertura.',
            'image.mimes'               => 'El archivo no es una imagen, el formato no esta permitido, el archivo debe ser jpg, jpeg, png o svg',
            'image.max'                 => ' El peso maximo de la imagen es de 512 KB.',
            'image.dimensions'          => ' La imagen tiene dimensiones de no válidas. El ancho y alto debe ser 400x200',
        ];
    }
}
