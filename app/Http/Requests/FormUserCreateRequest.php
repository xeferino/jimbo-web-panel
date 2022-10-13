<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormUserCreateRequest extends FormRequest
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
            'name'          => 'required|min:3',
            'email'         => 'required|email|unique:users,email',
            'role'          => 'required',
            'active'        => 'required',
            'password'      => 'required|min:8|max:16',
            'cpassword'     => 'required|min:8|max:16|required_with:password|same:password',
            'image'         => $this->hasFile('image') ? 'required|sometimes|mimes:jpeg,jpg,png,svg|max:512' : 'nullable',
            'dni'           => $this->has('dni') ? 'required|integer|unique:users,dni' : 'nullable',
            'phone'         => $this->has('phone') ? 'required|integer' : 'nullable',
            'country_id'    => $this->has('country_id') ? 'required|integer' : 'nullable',
            'balance_jib'   => $this->has('balance_jib') ? 'required|integer' : 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'role.required'         =>  'El rol es requerido.',
            'active.required'       =>  'El estatus es requerido.',
            'name.required'         =>  'El nombre es requerido.',
            'name.min'              =>  'El nombre debe contener un minimo de 3 caracteres.',
            'email.required'        =>  'El email es requerido.',
            'email.email'           =>  'Ingrese un email valido!',
            'email.unique'          =>  'El email ingresado ya existe!',
            'cpassword.required'    =>  'Confirmar contraseña es requerida.',
            'password.required'     =>  'La contraseña es requerida.',
            'password.min'          =>  'La contraseña debe debe contener un minimo de 8 caracteres.',
            'password.max'          =>  'La contraseña debe debe contener un maximo de 16 caracteres.',
            'cpassword.same'        =>  'La contraseña y confirmar contraseña deben coincidir.',
            'cpassword.max'         =>  'Confirmar contraseña debe debe contener un maximo de 16 caracteres.',
            'cpassword.min'         =>  'Confirmar contraseña debe debe contener un minimo de 8 caracteres.',
            'image.mimes'           =>  'El formato de imagen no esta permitido, la imagen debe ser jpg, jpeg, png o svg.',
            'image.max'             =>  'El peso maximo de la imagen es de 512 KB.',
            'dni.required'          =>  'El DNI es requerido.',
            'dni.integer'           =>  'El DNI debe ser entero.',
            'phone.required'        =>  'El telefono es requerido.',
            'phone.integer'         =>  'El telefono debe ser entero.',
            'country_id.required'   =>  'El pais es requerido.',
            'country_id.integer'    =>  'El pais debe ser entero.',
            'balance_jib.required'  =>  'El balance es requerido.',
            'balance_jib.integer'   =>  'El balance debe ser entero.',
        ];
    }
}
