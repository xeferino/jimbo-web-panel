<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormSettingRequest extends FormRequest
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
            'jib_usd'               => $this->type == 'jib' ? 'required|numeric|between:0.0,100' : 'nullable',
            'register'              => $this->type == 'bonus' ? 'required|integer' : 'nullable',
            'referrals'             => $this->type == 'bonus' ? 'required|integer' : 'nullable',
            'to_access'             => $this->type == 'bonus' ? 'required|integer' : 'nullable',
            'user_to_seller'        => $this->type == 'bonus' ? 'required|integer' : 'nullable',
            'level_single_junior'   => $this->type == 'seller_single' ? 'required|integer' : 'nullable',
            'level_single_middle'   => $this->type == 'seller_single' ? 'required|integer' : 'nullable',
            'level_single_master'   => $this->type == 'seller_single' ? 'required|integer' : 'nullable',
            'level_percent_single_junior'   => $this->type == 'seller_single_percent' ? 'required|integer' : 'nullable',
            'level_percent_single_middle'   => $this->type == 'seller_single_percent' ? 'required|integer' : 'nullable',
            'level_percent_single_master'   => $this->type == 'seller_single_percent' ? 'required|integer' : 'nullable',
            'level_group_junior'   => $this->type == 'seller_group' ? 'required|integer' : 'nullable',
            'level_group_middle'   => $this->type == 'seller_group' ? 'required|integer' : 'nullable',
            'level_group_master'   => $this->type == 'seller_group' ? 'required|integer' : 'nullable',
            'level_percent_group_junior'   => $this->type == 'seller_group_percent' ? 'required|integer' : 'nullable',
            'level_percent_group_middle'   => $this->type == 'seller_group_percent' ? 'required|integer' : 'nullable',
            'level_percent_group_master'   => $this->type == 'seller_group_percent' ? 'required|integer' : 'nullable',
            'level_classic_ascent_unique_bonus'   => $this->type == 'bonus_classic' ? 'required|integer' : 'nullable',
            'level_classic_referral_bonus'   => $this->type == 'bonus_classic' ? 'required|integer' : 'nullable',
            'level_classic_sale_percent'     => $this->type == 'bonus_classic' ? 'required|integer' : 'nullable',
            'level_percent_single_master'   => $this->type == 'seller_single_percent' ? 'required|integer' : 'nullable',
            'level_ascent_bonus_single_junior'   => $this->type == 'bonus_ascent' ? 'required|integer' : 'nullable',
            'level_ascent_bonus_single_middle'   => $this->type == 'bonus_ascent' ? 'required|integer' : 'nullable',
            'level_ascent_bonus_single_master'   => $this->type == 'bonus_ascent' ? 'required|integer' : 'nullable',
            'terms_and_conditions'               => $this->type == 'terms_and_conditions' ? 'required' : 'nullable',
            'game_rules'                         => $this->type == 'game_rules' ? 'required' : 'nullable',
            'policies_privacy'                   => $this->type == 'policies_privacy' ? 'required' : 'nullable',
            'faqs'                               => $this->type == 'faqs' ? 'required' : 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'jib_usd.required'    => 'El valor del jib es requerido.',
            'jib_usd.numeric'     => 'El valor del jib de cambio debe ser numerico.',
            'jib_usd.between'     => 'El valor del jib de cambio debe tener un formato en 0.00',
            'register.required'   => 'El valor del jib es requerido.',
            'referrals.required'  => 'El valor del jib es requerido.',
            'to_access.required'  => 'El valor del jib es requerido.',
            'register.integer'   => 'El valor del jib debe ser numerico.',
            'referrals.integer'  => 'El valor del jib debe ser numerico.',
            'to_access.integer'  => 'El valor del jib debe ser numerico.',
            'level_single_junior.required' => 'El valor es requerido',
            'level_single_junior.integer' => 'El valor debe ser numerico.',
            'level_single_middle.required' => 'El valor es requerido',
            'level_single_middle.integer' => 'El valor debe ser numerico.',
            'level_single_master.required' => 'El valor es requerido',
            'level_single_master.integer' => 'El valor debe ser numerico.',
            'level_percent_single_junior.required' => 'El valor es requerido',
            'level_percent_single_junior.integer' => 'El valor debe ser numerico.',
            'level_percent_single_middle.required' => 'El valor es requerido',
            'level_percent_single_middle.integer' => 'El valor debe ser numerico.',
            'level_percent_single_master.required' => 'El valor es requerido',
            'level_percent_single_master.integer' => 'El valor debe ser numerico.',
            'level_group_junior.required' => 'El valor es requerido',
            'level_group_junior.integer' => 'El valor debe ser numerico.',
            'level_group_middle.required' => 'El valor es requerido',
            'level_group_middle.integer' => 'El valor debe ser numerico.',
            'level_group_master.required' => 'El valor es requerido',
            'level_group_master.integer' => 'El valor debe ser numerico.',
            'level_percent_group_junior.required' => 'El valor es requerido',
            'level_percent_group_junior.integer' => 'El valor debe ser numerico.',
            'level_percent_group_middle.required' => 'El valor es requerido',
            'level_percent_group_middle.integer' => 'El valor debe ser numerico.',
            'level_percent_group_master.required' => 'El valor es requerido',
            'level_percent_group_master.integer' => 'El valor debe ser numerico.',
            'level_classic_ascent_unique_bonus.required' => 'El valor es requerido',
            'level_classic_ascent_unique_bonus.integer' => 'El valor debe ser numerico.',
            'user_to_seller.required' => 'El valor es requerido',
            'user_to_seller.integer' => 'El valor debe ser numerico.',
            'level_classic_referral_bonus.required' => 'El valor es requerido',
            'level_classic_referral_bonus.integer' => 'El valor debe ser numerico.',
            'level_classic_sale_percent.required' => 'El valor es requerido',
            'level_classic_sale_percent.integer' => 'El valor debe ser numerico.',
            'level_ascent_bonus_single_junior.required' => 'El valor es requerido',
            'level_ascent_bonus_single_junior.integer' => 'El valor debe ser numerico.',
            'level_ascent_bonus_single_middle.required' => 'El valor es requerido',
            'level_ascent_bonus_single_middle.integer' => 'El valor debe ser numerico.',
            'level_ascent_bonus_single_master.required' => 'El valor es requerido',
            'level_ascent_bonus_single_master.integer' => 'El valor debe ser numerico.',
            'terms_and_conditions.required' => 'Los terminos y condiciones son requeridos',
            'game_rules.required' => 'Las reglas del juego son requeridas',
            'policies_privacy.required' => 'Las politicas de privacidad son requeridas',
            'faqs.required' => 'Las preguntas frecuentes son requeridas',
        ];
    }
}
