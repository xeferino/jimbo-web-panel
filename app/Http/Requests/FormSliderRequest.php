<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormSliderRequest extends FormRequest
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
            'name' => 'required|min:3',
            'active'    => 'required',
            'image'       => $this->hasFile('image') ? 'required|sometimes|mimes:jpeg,jpg,png,svg|max:512|dimensions:width=400,height=200' : 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'name.required'     => 'El nombre es requerido.',
            'name.min'          => 'El nombre es requiere minimo :min caracteres.',
            'active.required'   => 'El estatus es requerido.',
            'image.mimes'       => 'El archivo no es una imagen, el formato no esta permitido, el archivo debe ser jpg, jpeg, png o svg',
            'image.max'         => ' El peso maximo de la imagen es de 512 KB.',
            'image.dimensions'  => ' La imagen tiene dimensiones de no válidas. El ancho y alto debe ser 400x200',
        ];
    }
}
