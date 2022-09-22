<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormRoleEditRequest extends FormRequest
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
            'name'              => 'required|min:4|unique:roles,name,'.$this->role->id,
            'description'       => 'required',
            'syncPermissions'   => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required'             => 'El nombre es requerido.',
            'name.min'                  => 'El nombre es requiere minimo :min caracteres.',
            'name.unique'               => 'El nombre debe ser unico.',
            'description.required'      => 'La descripcion es requerida.',
            'syncPermissions.required'  => 'Debe seleccionar al menos un permiso.'
        ];
    }
}
