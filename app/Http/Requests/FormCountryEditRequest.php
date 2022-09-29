<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormCountryEditRequest extends FormRequest
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
            'name' => 'required|min:3|unique:countries,name,'.$this->country->id.',id,deleted_at,NULL',
            //'name'      => 'required|min:3|unique:countries,name,'.$this->country->id,
            'code' => 'required|min:3|unique:countries,code,'.$this->country->id.',id,deleted_at,NULL',
            //'code'      => 'required|unique:countries,code,'.$this->country->id,
            'active'    => 'required',
            'img'       => $this->hasFile('img') ? 'required|image|sometimes|mimes:jpeg,jpg,png,svg|max:512|dimensions:width=20,height=20' : 'nullable',
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
            'image.mimes'       => 'El formato de imagen no esta permitido, la imagen debe ser jpg, jpeg, png o svg.',
            'image.max'         => 'El peso maximo de la imagen es de 512 KB.',
            'image.width'       => 'El ancho maximo de la imagen es de 20px.',
            'image.height'      => 'El alto maximo de la imagen es de 20px.',
            'image.image'       => 'El archivo no es una imagen',
        ];
    }
}
