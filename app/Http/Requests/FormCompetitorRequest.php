<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormCompetitorRequest extends FormRequest
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
            'names'         => 'required|min:3',
            'surnames'      => 'required|min:3',
            'email'         => isset($this->competitor->id) ? 'required|email|unique:users,email,'.$this->competitor->id : 'required|email|unique:users,email',
            'role'          => 'required',
            'active'        => 'required',
            'address'       => 'required|min:10',
            'address_city'  => 'required|min:10',
            'active'        => 'required',
            'password'      => isset($this->competitor->id) ? 'nullable|min:8|max:16' : 'required|min:8|max:16',
            'cpassword'     => isset($this->competitor->id) ? 'nullable|min:8|max:16|required_with:password|same:password' : 'required|min:8|max:16|required_with:password|same:password',
            'image'         => $this->hasFile('image') ? 'required|sometimes|mimes:jpeg,jpg,png,svg|max:512' : 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'role.required'              =>  'El rol es requerido.',
            'active.required'            =>  'El estatus es requerido.',
            'names.required'             =>  'El nombre es requerido.',
            'names.min'                  =>  'El nombre debe contener un minimo de :min caracteres.',
            'address.required'           =>  'La direcion es requerido.',
            'address.min'                =>  'La direcion debe contener un minimo de :min caracteres.',
            'address_city.required'      =>  'La direcion es requerido.',
            'address_city.min'           =>  'La direcion debe contener un minimo de :min caracteres.',
            'surnames.required'          =>  'El apellido es requerido.',
            'surnames.min'               =>  'El apellido debe contener un minimo de :min caracteres.',
            'email.required'             =>  'El email es requerido.',
            'email.email'                =>  'Ingrese un email valido!',
            'email.unique'               =>  'El email ingresado ya existe!',
            'cpassword.required_with'    =>  'Confirmar contraseña es requerida.',
            'cpassword.required'         =>  'Confirmar contraseña es requerida.',
            'password.required'          =>  'La contraseña es requerida.',
            'password.min'               =>  'La contraseña debe debe contener un minimo de 8 caracteres.',
            'password.max'               =>  'La contraseña debe debe contener un maximo de 16 caracteres.',
            'cpassword.same'             =>  'La contraseña y confirmar contraseña deben coincidir.',
            'cpassword.max'              =>  'Confirmar contraseña debe debe contener un maximo de 16 caracteres.',
            'cpassword.min'              =>  'Confirmar contraseña debe debe contener un minimo de 8 caracteres.',
            'image.mimes'                =>  'El formato de imagen no esta permitido, la imagen debe ser jpg, jpeg, png o svg.',
            'image.max'                  =>  'El peso maximo de la imagen es de 512 KB.',
            'dni.required'               =>  'El DNI es requerido.',
            'dni.integer'                =>  'El DNI debe ser entero.',
            'dni.unique'                 =>  'El DNI ingresado ya existe!',
            'phone.required'             =>  'El telefono es requerido.',
            'phone.integer'              =>  'El telefono debe ser entero.',
            'country_id.required'        =>  'El pais es requerido.',
            'country_id.integer'         =>  'El pais debe ser entero.',
            'balance_jib.required'       =>  'El balance es requerido.',
            'balance_jib.integer'        =>  'El balance debe ser entero.',
        ];
    }
}
