<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormFavoriteRequest extends FormRequest
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
            'user_id'       => 'required|integer',
            'raffle_id'     => 'required|integer',

        ];
    }

    public function messages()
    {
        return [
            'user_id.required'      => 'El usuario es requerido.',
            'user_id.integer'       => 'El usuario debe ser entero.',
            'raffle_id.required'    => 'El sorteo es requerido.',
            'raffle_id.integer'     => 'El sorteo debe ser entero.',
        ];
    }
}
