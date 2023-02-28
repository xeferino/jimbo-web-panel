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


            return response()->json(['modules' => [
                    'views'  =>  $views,
                    'menus'  =>  $menus
                ]], 200);

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
}
