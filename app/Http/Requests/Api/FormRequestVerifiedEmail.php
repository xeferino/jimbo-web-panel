<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FormRequestVerifiedEmail extends FormRequest
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
            'email' => 'required|email|users,email',
            'code'  => $this->has('code') ? 'required|exists:users,code' : 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'email.required'   =>  'El email es requerido.',
            'email.email'      =>  'Ingrese un email valido!',
            'code.required'    =>  'El codigo es requerido.',
            'code.exists'      =>  'El codigo ingresado es invalido, verifique!',
        ];
    }
}
