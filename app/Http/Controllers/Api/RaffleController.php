<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Models\Raffle;


class RaffleController extends Controller
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
        $this->asset = config('app.url').'/assets/images/raffles/';
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

            $raffles = Raffle::select(
                'id',
                'title',
                DB::raw("CONCAT(cash_to_draw,'$') AS cash_to_draw"),
                'date_start',
                'date_end',
                DB::raw("TIMESTAMPDIFF(DAY, now(), date_end) AS remaining_days"),
                DB::raw("CONCAT('".$this->asset."',image) AS logo"))
                ->where('active', 1)
                ->where('public', 0)
                ->whereNull('deleted_at')->get();

            return response()->json(['raffles' => $raffles], 200);

        } catch (Exception $e) {

            return response()->json([
                'status'   => 500,
                'message' =>  $e->getMessage()
            ], 500);
        }
    }
}
