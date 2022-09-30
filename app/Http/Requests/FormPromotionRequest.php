<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormPromotionRequest extends FormRequest
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
            'name'      => 'required|min:3',
            'code'      => 'required|min:3',
            'price'     => 'required|integer',
            'active'    => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required'     => 'El nombre es requerido.',
            'name.min'          => 'El nombre es requiere minimo :min caracteres.',
            'code.required'     => 'El codigo es requerido.',
            'code.min'          => 'El codigo es requiere minimo :min caracteres.',
            'price.required'    => 'El codigo es requerido.',
            'price.integer'     => 'El codigo debe ser entero.',
            'active.required'   => 'El estatus es requerido.',
        ];
    }
}
