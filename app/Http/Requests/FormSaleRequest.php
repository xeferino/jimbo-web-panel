<?php

namespace App\Http\Requests;

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
            'fullnames'     => 'required|min:3',
            'email'         => 'required|email',
            'dni'           => 'required|integer',
            'phone'         => 'required|string',
            'address'       => 'nullable|string',
            'country_id'    => 'required|integer',
            'raffle_id'     => $this->has('type') && $this->type == 'edit' ? 'nullable' : 'required|integer',
            'ticket_id'     => $this->has('type') && $this->type == 'edit' ? 'nullable' : 'required|integer',
            'address'       => 'required',
            'status'        => 'required'
        ];
    }

    public function messages()
    {
        return [
            'amount.required'           => 'El monto de la compra es requerido.',
            'amount.required'           => 'El monto de la compra debe ser entero',
            'country_id.required'       => 'El pais es requerido.',
            'country_id.integer'        => 'El pais debe ser entero.',
            'ticket_id.required'        => 'La promocion de boleto es requerida.',
            'ticket_id.integer'         => 'La promocion de boleto debe ser entero.',
            'seller_id.required'        => 'El vendedor es requerido.',
            'seller_id.integer'         => 'El vendedor debe ser entero.',
            'raffle_id.required'        => 'El sorteo es requerido.',
            'raffle_id.integer'         => 'El sorteo debe ser entero.',
            'user_id.required'          => 'El usuario es requerido.',
            'user_id.integer'           => 'El usuario  debe ser entero.',
            'method_type.required'      => 'El metodo de pago es requerido.',
            'method_id.required'        => 'El id de la tarjeta es requerida.',
            'method_id.integer'         => 'El id de la tarjeta  debe ser entero.',
            'fullnames.required'        =>  'Nombres y apellidos es requerido.',
            'fullnames.min'             =>  'Nombres y apellidos debe contener un minimo de 3 caracteres.',
            'email.required'            =>  'El email es requerido.',
            'email.email'               =>  'Ingrese un email valido!',
            'dni.required'              =>  'El DNI es requerido.',
            'dni.integer'               =>  'El DNI debe ser entero.',
            'phone.required'            =>  'El telefono es requerido.',
            'phone.string'              =>  'El telefono debe ser entero.',
            'address.required'          =>  'la direccion es requerida.',
            'address_city.required'     =>  'la ciudad es requerida.',
            'status.required'           =>  'El estado de la venta es requerido.',
        ];
    }
}
