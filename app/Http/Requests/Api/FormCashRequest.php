<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class FormCashRequest extends FormRequest
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
            'amount'            => 'required|integer',
            'user_id'           => 'required|integer',
            'account_user_id'   => 'required',
        ];
    }

    public function messages()
    {
        return [
            'amount.required'           => 'El monto de es requerido.',
            'amount.required'           => 'El monto de debe ser entero',
            'account_user_id.required'  => 'El id de la cuenta es requerida.',
            'user_id.required'          => 'El usuario es requerido.',
            'user_id.integer'           => 'El usuario  debe ser entero.',
            'method_type.required'      => 'El metodo de pago es requerido.',
        ];
    }
}