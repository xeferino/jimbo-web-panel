<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormRechargeRequest extends FormRequest
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
            'jib'           => $this->has('jib') ? 'required|integer' : 'nullable',
            'description'   => $this->has('description') ? 'required|min:10' : 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'jib.required'               =>  'El balance es requerido.',
            'jib.integer'                =>  'El balance debe ser entero.',
            'description.required'       =>  'La descripcion es requerida.',
            'description.min'            =>  'La descripcion debe contener un minimo de 10 caracteres.',
        ];
    }
}
