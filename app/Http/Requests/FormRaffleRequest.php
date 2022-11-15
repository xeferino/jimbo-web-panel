<?php

namespace App\Http\Requests;

use App\Helpers\Helper;
use Illuminate\Foundation\Http\FormRequest;

class FormRaffleRequest extends FormRequest
{
    protected $amount;
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
        $this->amount     = ((($this->cash_to_draw*$this->prize_1)/100)+(($this->cash_to_draw*$this->prize_2)/100)+(($this->cash_to_draw*$this->prize_3)/100)+(($this->cash_to_draw*$this->prize_4)/100)+(($this->cash_to_draw*$this->prize_5)/100)+(($this->cash_to_draw*$this->prize_6)/100)+(($this->cash_to_draw*$this->prize_7)/100)+(($this->cash_to_draw*$this->prize_8)/100)+(($this->cash_to_draw*$this->prize_9)/100)+(($this->cash_to_draw*$this->prize_10)/100));
        return [
            'title'             => 'required|min:3',
            'description'       => 'required|min:10',
            'brand'             => 'required|min:3',
            'promoter'          => 'required|min:3',
            'place'             => 'required|min:3',
            'provider'          => 'required|min:3',
            'cash_to_draw'      => 'required|integer|between:1.00,9999999.00',
            'cash_to_collect'   => 'required|integer|gt:'.$this->amount.'|between:1.00,9999999.00',
            'total'             => 'gte:cash_to_collect',
            'type'              => 'required',
            'days_extend'       => 'nullable|integer',
            'public'            => 'required',
            'active'            => 'required',
            'prize_1'           => 'required|numeric|between:0.0,100',
            'prize_2'           => 'required|numeric|between:0.0,100',
            'prize_3'           => 'required|numeric|between:0.0,100',
            'prize_4'           => 'required|numeric|between:0.0,100',
            'prize_5'           => 'required|numeric|between:0.0,100',
            'prize_6'           => 'required|numeric|between:0.0,100',
            'prize_7'           => 'required|numeric|between:0.0,100',
            'prize_8'           => 'required|numeric|between:0.0,100',
            'prize_9'           => 'required|numeric|between:0.0,100',
            'prize_10'          => 'required|numeric|between:0.0,100',
            'date_start'        => isset($this->raffle->id) ? 'required|date_format:d/m/Y' : 'required|date_format:d/m/Y|after_or_equal:'.date('d/m/Y'),
            'date_end'          => 'required|date_format:d/m/Y|after_or_equal:date_start',
            'date_release'      => 'required|date_format:d/m/Y|after_or_equal:date_end',
            'promotions_raffle' => isset($this->raffle->id) ? 'nullable' : 'required',
            //'percent'           => 'required',
            'promotions'        => isset($this->raffle->id) ? 'nullable' : 'required',
            //'quantity'          => 'required|integer',
            'image'             => $this->hasFile('image') ? 'required|sometimes|mimes:jpeg,jpg,png,svg|max:512|dimensions:width=400,height=200' : 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'title.required'                => 'El nombre es requerido.',
            'title.min'                     => 'El nombre es requiere minimo :min caracteres.',
            'description.required'          => 'La descripcion es requerida.',
            'description.min'               => 'La descripcion requiere minimo :min caracteres.',
            'brand.required'                => 'La marca es requerido.',
            'brand.min'                     => 'La marca es requiere minimo :min caracteres.',
            'promoter.required'             => 'El promotor es requerido.',
            'promoter.min'                  => 'El promotor es requiere minimo :min caracteres.',
            'place.required'                => 'La localidad es requerido.',
            'place.min'                     => 'La localidad es requiere minimo :min caracteres.',
            'provider.required'             => 'El proveedor es requerido.',
            'provider.min'                  => 'El proveedor es requiere minimo :min caracteres.',
            'cash_to_draw.required'         => 'El premio en efectivo es requerido.',
            'cash_to_draw.integer'          => 'El premio en efectivo debe ser entero.',
            'cash_to_collect.required'      => 'El dinero a recaudar es requerido.',
            'cash_to_collect.integer'       => 'El dinero a recaudar debe ser entero.',
            'cash_to_collect.gt'            => 'El dinero a recaudar debe ser mayor a las premiaciones '.Helper::amount($this->amount),
            'total.gte'                     => 'Por favor verifique la cantidad de boletos configurados, el total debe ser mayor o igual al dinero a recaudar :'.Helper::amount($this->input('cash_to_collect')),
            'days_extend.integer'           => 'El valor ingresado para extender el sorteo es invalido.',
            'type.required'                 => 'El tipo es requerido.',
            'public.required'               => 'La visibilidad es requerida.',
            'active.required'               => 'El estatus es requerido.',
            'prize_1.required'              => 'El porcentaje es requerido.',
            'prize_2.required'              => 'El porcentaje es requerido.',
            'prize_3.required'              => 'El porcentaje es requerido.',
            'prize_4.required'              => 'El porcentaje es requerido.',
            'prize_5.required'              => 'El porcentaje es requerido.',
            'prize_6.required'              => 'El porcentaje es requerido.',
            'prize_7.required'              => 'El porcentaje es requerido.',
            'prize_8.required'              => 'El porcentaje es requerido.',
            'prize_9.required'              => 'El porcentaje es requerido.',
            'prize_10.required'             => 'El porcentaje es requerido.',
            'prize_1.numeric'              => 'El porcentaje debe ser numerico.',
            'prize_2.numeric'              => 'El porcentaje debe ser numerico.',
            'prize_3.numeric'              => 'El porcentaje debe ser numerico.',
            'prize_4.numeric'              => 'El porcentaje debe ser numerico.',
            'prize_5.numeric'              => 'El porcentaje debe ser numerico.',
            'prize_6.numeric'              => 'El porcentaje debe ser numerico.',
            'prize_7.numeric'              => 'El porcentaje debe ser numerico.',
            'prize_8.numeric'              => 'El porcentaje debe ser numerico.',
            'prize_9.numeric'              => 'El porcentaje debe ser numerico.',
            'prize_10.numeric'             => 'El porcentaje debe ser numerico.',
            'prize_1.between'              => 'El porcentaje debe estar entre 0.00 y 100.',
            'prize_2.between'              => 'El porcentaje debe estar entre 0.00 y 100.',
            'prize_3.between'              => 'El porcentaje debe estar entre 0.00 y 100.',
            'prize_4.between'              => 'El porcentaje debe estar entre 0.00 y 100.',
            'prize_5.between'              => 'El porcentaje debe estar entre 0.00 y 100.',
            'prize_6.between'              => 'El porcentaje debe estar entre 0.00 y 100.',
            'prize_7.between'              => 'El porcentaje debe estar entre 0.00 y 100.',
            'prize_8.between'              => 'El porcentaje debe estar entre 0.00 y 100.',
            'prize_9.between'              => 'El porcentaje debe estar entre 0.00 y 100.',
            'prize_10.between'             => 'El porcentaje debe estar entre 0.00 y 100.',
            'date_start.required'           => 'La fecha de apertura es requerida.',
            'date_start.date'               => 'La fecha de apertura no es valida.',
            'date_start.after_or_equal'     => 'La fecha  de apertura no puede ser menor a la fecha de actual ('.date('d/m/Y').')',
            'date_end.required'             => 'La fecha de cierre es requerida.',
            'date_end.date'                 => 'La fecha  de cierre no es valida.',
            'date_end.after_or_equal'       => 'La fecha  de cierre no puede ser menor a la fecha de apertura.',
            'date_release.required'         => 'La fecha del sorteo es requerida.',
            'date_release.date'             => 'La fecha  del sorteo no es valida.',
            'date_release.after_or_equal'   => 'La fecha  del sorteo no puede ser menor a la fecha de cierre.',
            'promotions_raffle.required'    => 'debe configurar promociones de boletos.',
            'promotions.required'           => 'Las promociones son requeridas, para la creacion del sorteo.',
            'percent.required'              => 'Porcentaje de la pasarela es requerido',
            'quantity.required'             => 'La cantidad es requerida.',
            'quantity.integer'              => 'La cantidad debe ser entera.',
            'image.mimes'                   => 'El archivo no es una imagen, el formato no esta permitido, el archivo debe ser jpg, jpeg, png o svg',
            'image.max'                     => ' El peso maximo de la imagen es de 512 KB.',
            'image.dimensions'              => ' La imagen tiene dimensiones de no válidas. El ancho y alto debe ser 400x200',
        ];
    }
}
