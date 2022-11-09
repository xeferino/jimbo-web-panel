<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class FormSaleRequest extends FormRequest
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
            'name'          => $this->has('other') && $this->other == 1 ? 'required|min:3' : 'nullable',
            'email'         => $this->has('other') && $this->other == 1 ? 'required|email' : 'nullable',
            'dni'           => $this->has('other') && $this->other == 1 ? 'required|integer' : 'nullable',
            'phone'         => $this->has('other') && $this->other == 1 ? 'required|string' : 'nullable',
            'address'       => $this->has('other') && $this->other == 1 ? 'required|string' : 'nullable',
            'country_id'    => 'required|integer',
            'raffle_id'     => 'required|integer',
            'ticket_id'     => 'required|integer',
            'seller_id'     => $this->has('other') && $this->other == 1 ? 'required|integer' : 'nullable',
            'user_id'       => 'required|integer',
            'method_id'     => 'required|integer',
            'method_type'   => 'required',
        ];
    }

    public function messages()
    {
        return [
            'amount.required'           => 'El monto de la compra es requerido.',
            'amount.required'           => 'El monto de la compra debe ser entero',
            'country_id.required'       => 'El pais es requerido.',
            'country_id.integer'        => 'El pais debe ser entero.',
            'ticket_id.required'        => 'El ticket es requerido.',
            'ticket_id.integer'         => 'El ticket debe ser entero.',
            'seller_id.required'        => 'El vendedor es requerido.',
            'seller_id.integer'         => 'El vendedor debe ser entero.',
            'raffle_id.required'        => 'El sorteo es requerido.',
            'raffle_id.integer'         => 'El sorteo debe ser entero.',
            'user_id.required'          => 'El usuario es requerido.',
            'user_id.integer'           => 'El usuario  debe ser entero.',
            'method_type.required'      => 'El metodo de pago es requerido.',
            'method_id.required'        => 'El id de la tarjeta es requerida.',
            'method_id.integer'         => 'El id de la tarjeta  debe ser entero.',
            'name.required'             =>  'El nombre es requerido.',
            'name.min'                  =>  'El nombre debe contener un minimo de 3 caracteres.',
            'email.required'            =>  'El email es requerido.',
            'email.email'               =>  'Ingrese un email valido!',
            'dni.required'              =>  'El DNI es requerido.',
            'dni.integer'               =>  'El DNI debe ser entero.',
            'phone.required'            =>  'El telefono es requerido.',
            'phone.string'              =>  'El telefono debe ser entero.',
            'address.required'          =>  'La direcion es requerida.',
        ];
    }
}
