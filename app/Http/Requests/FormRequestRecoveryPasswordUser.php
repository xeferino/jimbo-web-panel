<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FormRequestRecoveryPasswordUser extends FormRequest
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
            'email'         => 'required|email|exists:users,email',
            'code'          => 'required|exists:users,code',
            'password'      => 'required|min:8|max:16',
            'cpassword'     => 'required|min:8|max:16|required_with:password|same:password',
        ];
    }

    public function messages()
    {
        return [
            'email.required'        =>  'El email es requerido.',
            'email.email'           =>  'Ingrese un email valido!',
            'email.exists'          =>  'El email ingresado no existe, verifique!',
            'code.required'         =>  'El codido es requerido.',
            'code.exists'           =>  'El codigo ingresado es invalido, verifique!',
            'cpassword.required'    =>  'Confirmar contraseña es requerida.',
            'password.required'     =>  'La contraseña es requerida.',
            'password.min'          =>  'La contraseña debe debe contener un minimo de 8 caracteres.',
            'password.max'          =>  'La contraseña debe debe contener un maximo de 16 caracteres.',
            'cpassword.same'        =>  'La contraseña y confirmar contraseña deben coincidir.',
            'cpassword.max'         =>  'Confirmar contraseña debe debe contener un maximo de 16 caracteres.',
            'cpassword.min'         =>  'Confirmar contraseña debe debe contener un minimo de 8 caracteres.',
        ];
    }
}
