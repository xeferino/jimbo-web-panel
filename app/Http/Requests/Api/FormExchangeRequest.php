<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class FormExchangeRequest extends FormRequest
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
            'amout_jib'     => 'required|integer|numeric|between:10,9999999',
            'user_id'       => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'amout_jib.required'        => 'El monto de jib es requerido.',
            'amout_jib.numeric'         => 'El monto de jib debe ser numerico',
            'amout_jib.integer'         => 'El monto de jib debe ser entero',
            'amout_jib.between'         => 'El monto minimo de cambio es de 10.00 jib',
            'user_id.required'          => 'El usuario es requerido.',
            'user_id.integer'           => 'El usuario  debe ser entero.',
            'method_type.required'      => 'El metodo de pago es requerido.',
        ];
    }
}
