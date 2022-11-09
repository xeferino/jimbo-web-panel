<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FormChangeStatuRequest extends FormRequest
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
            'status'        => 'required', Rule::in(['approved', 'refused', 'pending', 'return', 'created']),
            'observation'   => 'required|min:10'
        ];
    }

    public function messages()
    {
        return [
            'status.required'            =>  'El estado de la solicitud es requerida.',
            'status.rule'                =>  'Elija una opcion valida.',
            'observation.required'       =>  'La observacion es requerida.',
            'observation.min'            =>  'La observacion debe contener un minimo de 10 caracteres.',
        ];
    }
}
