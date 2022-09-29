<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Models\Country;


class CountryController extends Controller
{

    private $asset;
    private $data;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->asset = config('app.url').'/assets/images/flags/';
        $this->data = [];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {

            $contries = Country::select('id', 'name', 'code', DB::raw("CONCAT('".$this->asset."',img) AS icon"))->where('active', 1)->whereNull('deleted_at')->get();
            return response()->json(['contries' => $contries], 200);

        } catch (Exception $e) {

            return response()->json([
                'status'   => 400,
                'message' =>  $e->getMessage()
            ], 400);
        }
    }
}
