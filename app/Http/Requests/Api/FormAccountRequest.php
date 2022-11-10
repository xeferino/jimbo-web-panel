<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class FormAccountRequest extends FormRequest
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
            'bank'      => 'required|min:3',
            'number'    => 'required|numeric|digits_between:6,20',
            'type'      => 'required|min:3',
            'user_id'   => 'required|integer',
            'name'      => $this->has('name') ? 'required|min:3' : 'nullable',
            'email'     => $this->has('email') ? 'required|email' : 'nullable',
            'dni'       => $this->has('dni') ? 'required|integer' : 'nullable',
            'phone'     => $this->has('phone') ? 'required|string' : 'nullable',

        ];
    }

    public function messages()
    {
        return [
            'bank.required'             => 'El nombre del banco es requerido.',
            'bank.min'                  => 'El nombre del banco al menos debe tener min: caracteres.',
            'type.required'             => 'El tipo de cuenta es requerido.',
            'type.min'                  => 'El tipo de cuenta al menos debe tener min: caracteres.',
            'number.required'           => 'El numero de cuenta es requerido.',
            'number.numeric'            => 'El numero de cuenta debe ser entero.',
            'number.digits_between'     => 'El numero de cuenta debe contener contener entre 6 y 20 digitos.',
            'user_id.required'          => 'El usuario es requerido.',
            'name.required'             =>  'El nombre es requerido.',
            'name.min'                  =>  'El nombre debe contener un minimo de 3 caracteres.',
            'email.required'            =>  'El email es requerido.',
            'email.email'               =>  'Ingrese un email valido!',
            'dni.required'              =>  'El DNI es requerido.',
            'dni.integer'               =>  'El DNI debe ser entero.',
            'phone.required'            =>  'El telefono es requerido.',
            'phone.string'              =>  'El telefono debe ser entero.',
        ];
    }
}
