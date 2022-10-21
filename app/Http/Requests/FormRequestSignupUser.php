<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FormRequestSignupUser extends FormRequest
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
            'name'          => 'required|regex:/^[a-zA-Z\s]+$/u|min:3',
            'email'         => 'required|email|unique:users,email',
            'dni'           => 'required|integer',
            'phone'         => 'required|string',
            'country_id'    => 'required',
            'password'      => 'required|min:8|max:16',
            'cpassword'     => 'required|required_with:password|same:password',
        ];
    }

    public function messages()
    {
        return [
            'country_id.required'           =>  'El Pais es requerido.',
            'dni.required'                  =>  'El DNI es requerido.',
            'dni.integer'                   =>  'El DNI debe ser entero.',
            'name.required'                 =>  'El nombre es requerido.',
            'name.min'                      =>  'El nombre debe contener un minimo de 3 caracteres.',
            'name.regex'                    =>  'El nombre debe contener solo letras y espacios.',
            'phone.required'                =>  'El telefono es requerido.',
            'phone.string'                  =>  'El telefono debe ser entero.',
            'email.required'                =>  'El email es requerido.',
            'email.email'                   =>  'Ingrese un email valido!',
            'email.unique'                  =>  'El email ingresado ya existe!',
            'cpassword.required'            =>  'Confirmar contraseña es requerida.',
            'password.required'             =>  'La contraseña es requerida.',
            'password.min'                  =>  'La contraseña debe contener un minimo de 8 caracteres.',
            'password.max'                  =>  'La contraseña debe contener un maximo de 16 caracteres.',
            'cpassword.same'                =>  'La contraseña y confirmar contraseña deben coincidir.',
        ];
    }
}
