<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\FormSettingRequest;
use Illuminate\Support\Facades\File;
use App\Models\Setting;
use DataTables;


class SettingController extends Controller
{
    /**
     * Show the form for updationg settings.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = Setting::pluck('value','name');
        return view('panel.settings.index', [
            'title'              => 'Configuraciones',
            'title_header'       => 'Configuraciones',
            'description_module' => 'Configuraciones en el sistema.',
            'title_nav'          => 'Actualizar',
            'icon'               => 'icofont-gear',
            'settings'           => $settings
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FormSettingRequest $request, Setting $setting)
    {
        $type = $request->type;
        if($type == 'jib') {
                $setting = Setting::where('name', 'jib_usd')->first();
                $setting->value = $request->jib_usd;
                $setting->save();
        } elseif($type == 'bonus'){
            $register  = Setting::where('name', 'register')->first();
            $register->value = $request->register;
            $register->save();
            $referrals  = Setting::where('name', 'referrals')->first();
            $referrals->value = $request->referrals;
            $referrals->save();
            $to_access  = Setting::where('name', 'to_access')->first();
            $to_access->value = $request->to_access;
            $to_access->save();
        } elseif($type == 'seller_single'){
            $level_single_junior  = Setting::where('name', 'level_single_junior')->first();
            $level_single_junior->value = $request->level_single_junior;
            $level_single_junior->save();
            $level_single_middle  = Setting::where('name', 'level_single_middle')->first();
            $level_single_middle->value = $request->level_single_middle;
            $level_single_middle->save();
            $level_single_master  = Setting::where('name', 'level_single_master')->first();
            $level_single_master->value = $request->level_single_master;
            $level_single_master->save();
        } elseif($type == 'seller_single_percent'){
            $level_percent_single_junior  = Setting::where('name', 'level_percent_single_junior')->first();
            $level_percent_single_junior->value = $request->level_percent_single_junior;
            $level_percent_single_junior->save();
            $level_percent_single_middle  = Setting::where('name', 'level_percent_single_middle')->first();
            $level_percent_single_middle->value = $request->level_percent_single_middle;
            $level_percent_single_middle->save();
            $level_percent_single_master  = Setting::where('name', 'level_percent_single_master')->first();
            $level_percent_single_master->value = $request->level_percent_single_master;
            $level_percent_single_master->save();
        } elseif($type == 'seller_group'){
            $level_group_junior  = Setting::where('name', 'level_group_junior')->first();
            $level_group_junior->value = $request->level_group_junior;
            $level_group_junior->save();
            $level_group_middle  = Setting::where('name', 'level_group_middle')->first();
            $level_group_middle->value = $request->level_group_middle;
            $level_group_middle->save();
            $level_group_master  = Setting::where('name', 'level_group_master')->first();
            $level_group_master->value = $request->level_group_master;
            $level_group_master->save();
        } elseif($type == 'seller_group_percent'){
            $level_percent_group_junior  = Setting::where('name', 'level_percent_group_junior')->first();
            $level_percent_group_junior->value = $request->level_percent_group_junior;
            $level_percent_group_junior->save();
            $level_percent_group_middle  = Setting::where('name', 'level_percent_group_middle')->first();
            $level_percent_group_middle->value = $request->level_percent_group_middle;
            $level_percent_group_middle->save();
            $level_percent_group_master  = Setting::where('name', 'level_percent_group_master')->first();
            $level_percent_group_master->value = $request->level_percent_group_master;
            $level_percent_group_master->save();
        } elseif($type == 'bonus_classic') {
            $level_classic_ascent_unique_bonus = Setting::where('name', 'level_classic_ascent_unique_bonus')->first();
            $level_classic_ascent_unique_bonus->value = $request->level_classic_ascent_unique_bonus;
            $level_classic_ascent_unique_bonus->save();
            $level_classic_seller_percent = Setting::where('name', 'level_classic_seller_percent')->first();
            $level_classic_seller_percent->value = $request->level_classic_seller_percent;
            $level_classic_seller_percent->save();
            $level_classic_referral_bonus = Setting::where('name', 'level_classic_referral_bonus')->first();
            $level_classic_referral_bonus->value = $request->level_classic_referral_bonus;
            $level_classic_referral_bonus->save();
            $level_classic_sale_percent = Setting::where('name', 'level_classic_sale_percent')->first();
            $level_classic_sale_percent->value = $request->level_classic_sale_percent;
            $level_classic_sale_percent->save();
        } elseif($type == 'bonus_ascent') {
            $level_ascent_bonus_single_junior = Setting::where('name', 'level_ascent_bonus_single_junior')->first();
            $level_ascent_bonus_single_junior->value = $request->level_ascent_bonus_single_junior;
            $level_ascent_bonus_single_junior->save();
            $level_ascent_bonus_single_middle = Setting::where('name', 'level_ascent_bonus_single_middle')->first();
            $level_ascent_bonus_single_middle->value = $request->level_ascent_bonus_single_middle;
            $level_ascent_bonus_single_middle->save();
            $level_ascent_bonus_single_master = Setting::where('name', 'level_ascent_bonus_single_master')->first();
            $level_ascent_bonus_single_master->value = $request->level_ascent_bonus_single_master;
            $level_ascent_bonus_single_master->save();
        } elseif($type == 'terms_and_conditions') {
            $terms_and_conditions = Setting::where('name', 'terms_and_conditions')->first();
            $terms_and_conditions->value = $request->terms_and_conditions;
            $terms_and_conditions->save();
    }
        return response()->json(['success' => true, 'message' => 'Jimbo panel notifica: Configuracion agregada exitosamente!'], 200);
    }

    public static function bonus()
    {
        $register  = Setting::where('name', 'register')->first();
        $referrals = Setting::where('name', 'referrals')->first();
        $to_access = Setting::where('name', 'to_access')->first();

        return [
            /*
            |--------------------------------------------------------------------------
            | Jibs change app
            |--------------------------------------------------------------------------
            */
            'bonus' => [
                'register'      => $register->value,
                'referrals'     =>  $referrals->value,
                'to_access'     =>  $to_access->value
            ]
        ];

    }

    public static function jib()
    {
        $jib_usd = DB::table('settings')->where('name', 'jib_usd')->first();
        $jib_unit_x_usd = DB::table('settings')->where('name', 'jib_unit_x_usd')->first();

        return [
            /*
            |--------------------------------------------------------------------------
            | Jibs set config value
            |--------------------------------------------------------------------------
            */
            'value' => [
                'jib_usd'         =>  $jib_usd->value,
                'jib_unit_x_usd'  =>  $jib_unit_x_usd->value
            ]
        ];

    }
}
