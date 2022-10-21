<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FormRequestVerifiedEmailUser extends FormRequest
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
            'email' => 'required|email|exists:users,email',
            'code'  => $this->has('code') ? 'required|integer|exists:users,code' : 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'email.required'   =>  'El email es requerido.',
            'email.email'      =>  'Ingrese un email valido!',
            'email.exists'     =>  'El email ingresado no existe, verifique!',
            'code.required'    =>  'El codigo es requerido.',
            'code.integer'     =>  'El codido debe ser entero.',
            'code.exists'      =>  'El codigo ingresado es invalido, verifique!',
        ];
    }
}
