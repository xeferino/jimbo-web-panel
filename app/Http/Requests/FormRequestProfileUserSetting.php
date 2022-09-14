<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Rules\ValidatePassword;
class FormRequestProfileUserSetting extends FormRequest
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
        if ($this->password_new !== null) {
            return [
                'name'              => 'required|regex:/^[a-zA-Z\s]+$/u|min:3',
                'email'             => 'required|email|unique:users,email,'.Auth::user()->id,
                'date_of_birth'     => 'required|date',
                'phone'             => 'required|integer',
                'gender'            => 'required|in:M,F|max:1',
                'password'          => ['required_with:password_new', new ValidatePassword(Auth::user())],
                'password_new'      => 'nullable|required_with:password|min:8|max:16',
                'password_repeat'   => 'nullable|required_with:password_new|same:password_new',
            ];
        }
        if ($this->password !== null) {
            return [
                'name'              => 'required|regex:/^[a-zA-Z\s]+$/u|min:3',
                'email'             => 'required|email|unique:users,email,'.Auth::user()->id,
                'date_of_birth'     => 'required|date',
                'phone'             => 'required|integer',
                'gender'            => 'required|in:M,F|max:1',
                'password'          => ['nullable', new ValidatePassword(Auth::user())],
                'password_new'      => 'nullable',
                'password_repeat'   => 'nullable',
            ];
        } else {
            return [
                'name'              => 'required|regex:/^[a-zA-Z\s]+$/u|min:3',
                'email'             => 'required|email|unique:users,email,'.Auth::user()->id,
                'date_of_birth'     => 'required|date',
                'phone'             => 'required|integer',
                'gender'            => 'required|in:M,F|max:1',
                'password'          => ['nullable', new ValidatePassword(Auth::user())],
                'password_new'      => 'nullable|required_with:password|min:8|max:16',
                'password_repeat'   => 'nullable|required_with:password_new|same:password_new',
            ];
        }
    }

    public function messages()
    {
        return [
            'date_of_birth.required'        =>  'La fecha de naciemiento es requerida.',
            'date_of_birth.date'            =>  'La fecha es invalida.',
            'date_of_birth.before_or_equal' =>  'La fecha debe ser menor o igual '.date('Y-m-d').'.',
            'name.required'                 =>  'El nombre es requerido.',
            'name.min'                      =>  'El nombre debe contener un minimo de 3 caracteres.',
            'name.regex'                    =>  'El nombre debe contener solo letras y espacios.',
            'gender.required'               =>  'El genero es requrido.',
            'gender.in'                     =>  'El genero solo acepta valores (M,F).',
            'gender.max'                    =>  'El genero debe contener un maximo de 1 caracteres.',
            'phone.required'                =>  'El telefono es requerido.',
            'phone.integer'                 =>  'El telefono debe ser entero.',
            'email.required'                =>  'El email es requerido.',
            'email.email'                   =>  'Ingrese un email valido!',
            'email.unique'                  =>  'El email ingresado ya existe!',
            'password.required_with'        =>  'La vieja contraseña es requerida.',
            'password_new.required_with'    =>  'La nueva contraseña es requerida.',
            'password_new.min'              =>  'La nueva contraseña debe debe contener un minimo de 8 caracteres.',
            'password_new.max'              =>  'La nueva contraseña debe debe contener un maximo de 16 caracteres.',
            'password_repeat.min'           =>  'Confirmar contraseña debe debe contener un minimo de 8 caracteres.',
            'password_repeat.max'           =>  'Confirmar contraseña debe debe contener un maximo de 16 caracteres.',
            'password_repeat.required_with' =>  'Confirmar contraseña es requerida.',
            'password_repeat.same'          =>  'La nueva contraseña y confirmar contraseña deben coincidir.',
        ];
    }
}
