<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\FormSettingRequest;
use Illuminate\Support\Facades\File;
use App\Models\Setting;
use DataTables;
use Exception;


class SettingController extends Controller
{
    /**
     * Show the form for updationg settings.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return response()->json(
                ['menus' => [
                    'menu_payment'          => $this->modulesActive('menu', 'menu_payment'),
                    'menu_balance'          => $this->modulesActive('menu', 'menu_balance'),
                    'menu_shopping'         => $this->modulesActive('menu', 'menu_shopping'),
                    'menu_sale'             => $this->modulesActive('menu', 'menu_sale'),
                    'menu_payment_method'   => $this->modulesActive('menu', 'menu_payment_method'),
                    'menu_account'          => $this->modulesActive('menu', 'menu_account'),
                    'menu_cash_request'     => $this->modulesActive('menu', 'menu_cash_request'),
                    'menu_jib'              => $this->modulesActive('menu', 'menu_jib'),
                    'menu_seller'           => $this->modulesActive('menu', 'menu_seller'),
                    'menu_contact'          => $this->modulesActive('menu', 'menu_contact'),
                    'menu_info'             => $this->modulesActive('menu', 'menu_info'),
                    'menu_logout'           => $this->modulesActive('menu', 'menu_logout')
                ],
                'views' => [
                    'view_home'             => $this->modulesActive('view', 'view_home'),
                    'view_winner'           => $this->modulesActive('view', 'view_winner'),
                    'view_notification'     => $this->modulesActive('view', 'view_notification'),
                    'view_roulette'         => $this->modulesActive('view', 'view_roulette'),
                    'view_perfil'           => $this->modulesActive('view', 'view_perfil'),
                    'view_free'             => $this->modulesActive('view', 'view_free'),
                    'view_recharge'         => $this->modulesActive('view', 'view_recharge')
                ],
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status'   => 400,
                'message' =>  $e->getMessage()
            ], 400);
        }
    }

    public static function moduleViewMenu()
    {
        $mod_views = DB::table('settings')->where('name', 'like',"%view_%")->get();
        $mod_menus = DB::table('settings')->where('name', 'like',"%menu_%")->get();
        $views = [];
        foreach ($mod_views as $key => $data) {
            # code...
            array_push($views, [
                'id' => $data->id,
                'name' => $data->name,
                'visibility' => $data->value == 1 ? true : false,
            ]);
        }
        $menus = [];
        foreach ($mod_menus as $key => $data) {
            # code...
            array_push($menus, [
                'id' => $data->id,
                'name' => $data->name,
                'visibility' => $data->value == 1 ? true : false,
            ]);
        }
        return [
            /*
            |--------------------------------------------------------------------------
            | Jibs set config value
            |--------------------------------------------------------------------------
            */
            'modules' => [
                'views'  =>  $views,
                'menus'  =>  $menus
            ]
        ];
    }

    private function modulesActive($type, $name)
    {
        $active = null;
        if ($type == 'menu') {
            $menu = DB::table('settings')->where('name', $name)->first();
            if($menu) {
                $active = $menu->value == 1 ? true : false;
            }
        }
        if ($type == 'view'){
            $view = DB::table('settings')->where('name', $name)->first();
            if($view) {
                $active = $view->value == 1 ? true : false;
            }
        }
        return $active;
    }
}
