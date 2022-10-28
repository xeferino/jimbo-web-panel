<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class FormCardRequest extends FormRequest
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
            'bank'              => 'required|min:3',
            'number'            => isset($this->card->id) ? 'required|numeric|digits_between:6,20|unique:card_users,number,'.$this->card->id : 'required|numeric|digits_between:6,20|unique:card_users,number',
            'type'              => 'required|min:3',
            'code'              => 'required|min:3',
            'date_expire'       => 'required|date_format:m/y',
            'user_id'           => 'required|integer',

        ];
    }

    public function messages()
    {
        return [
            'bank.required'             => 'El nombre del banco es requerido.',
            'bank.min'                  => 'El nombre del banco al menos debe tener min: caracteres.',
            'number.required'           => 'El numero de tarjeta es requerido.',
            'number.numeric'            => 'El numero de tarjeta debe ser entero.',
            'number.digits_between'     => 'El numero de tarjeta debe contener contener entre 6 y 20 digitos.',
            'number.unique'             => 'El numero de tarjeta debe ser unico.',
            'code.required'             => 'El codigo es requerido.',
            'code.required'             => 'El codigo es debe tener min: caracteres como minimo.',
            'date_expire.required'      => 'La fecha de vencimiento de la tarjeta es requerida.',
            'date_expire.date_format'   => 'El formato de la fecha de vencimiento de la tarjeta es invalido. ejemplo:'.date('m/y'),
            'user_id.required'          => 'El usuario es requerido.',
        ];
    }
}
