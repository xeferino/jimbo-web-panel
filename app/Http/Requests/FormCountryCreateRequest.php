<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormCountryCreateRequest extends FormRequest
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
            'name' => 'required|min:3|unique:countries,name,'.$this->country.',id,deleted_at,NULL',
            'code' => 'required|min:3|unique:countries,code,'.$this->country.',id,deleted_at,NULL',
            //'name'      => 'required|min:3|unique:countries,name',
            //'code'      => 'required|unique:countries,code',
            'active'    => 'required',
            'img'       => $this->hasFile('img') ? 'required|sometimes|mimes:jpeg,jpg,png,svg|max:512|dimensions:width=20,height=20' : 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'name.required'     => 'El nombre es requerido.',
            'name.min'          => 'El nombre es requiere minimo :min caracteres.',
            'name.unique'       => 'El nombre debe ser unico.',
            'code.unique'       => 'El codigo debe ser unico.',
            'code.required'     => 'El codigo es requerido.',
            'active.required'   => 'El estatus es requerido.',
            'name.required'     => 'El nombre es requerido.',
            //'img.image'         => 'El archivo no es una imagen ',
            'img.mimes'         => 'El archivo no es una imagen, el formato no esta permitido, el archivo debe ser jpg, jpeg, png o svg',
            'img.max'           => ' El peso maximo de la imagen es de 512 KB.',
            'img.dimensions'    => ' La imagen tiene dimensiones de no válidas. El ancho y alto debe ser 20x20.',
        ];
    }
}
