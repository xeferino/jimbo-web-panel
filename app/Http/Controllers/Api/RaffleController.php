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
                ->where('public', 1)
                ->whereNull('deleted_at')->get();

            return response()->json(['raffles' => $raffles], 200);

        } catch (Exception $e) {

            return response()->json([
                'status'   => 500,
                'message' =>  $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        try {
            $raffle = Raffle::findOrFail(13);
            $data = [];
            $tickets = [];
            $promotions = [];

            foreach ($raffle->tickets as $key => $value) {
                array_push($tickets, [
                    'id'            => $value->id,
                    'serial'        => $value->serial,
                    'promotion_id'  => $value->promotion_id,
                    'raffle_id'     => $value->raffle_id,
                    'quantity'      => $value->quantity,
                    'total'         => $value->total,
                ]);
            }

            foreach ($raffle->tickets as $key => $value) {
                array_push($promotions, [
                    'id' => $value->promotion->id,
                    'name' => $value->promotion->name,
                    'code' => $value->promotion->code,
                    'price' => $value->promotion->price,
                    'quantity' => $value->promotion->quantity,
                    'active' => $value->promotion->active,
                ]);
            }

            array_push($data, [
                'raflle' => [
                    'id' => $raffle->id,
                    'title' => $raffle->title,
                    'description' => $raffle->description,
                    'brand' => $raffle->brand,
                    'promoter' => $raffle->promoter,
                    'place' => $raffle->place,
                    'provider' => $raffle->provider,
                    'cash_to_draw' => $raffle->cash_to_draw,
                    'image'  => $raffle->image != 'raffle.jpg' ? $this->asset.$raffle->image : $this->asset.'raffle.jpg',
                    'date_start' => $raffle->date_start->format('d/m/Y'),
                    'date_end' => $raffle->date_end->format('d/m/Y'),
                    'date_release' => $raffle->date_release->format('d/m/Y'),
                    'date_extend' => $raffle->date_extend != null ? $raffle->date_extend->format('d/m/Y') : 'No hay fecha de prorroga',
                    'active' => $raffle->active,
                    'public' => $raffle->public,
                    'awards' => [
                        'first' => ($raffle->cash_to_draw*$raffle->prize_1)/100,
                        'second' => ($raffle->cash_to_draw*$raffle->prize_2)/100,
                        'third' => ($raffle->cash_to_draw*$raffle->prize_3)/100,
                        'fourth' => ($raffle->cash_to_draw*$raffle->prize_4)/100,
                        'fifth' => ($raffle->cash_to_draw*$raffle->prize_5)/100,
                        'sixth' => ($raffle->cash_to_draw*$raffle->prize_6)/100,
                        'seventh' => ($raffle->cash_to_draw*$raffle->prize_7)/100,
                        'eighth' => ($raffle->cash_to_draw*$raffle->prize_8)/100,
                        'nineth' => ($raffle->cash_to_draw*$raffle->prize_9)/100,
                        'tenth' => ($raffle->cash_to_draw*$raffle->prize_10)/100,
                    ],
                    'promotions' => $promotions,
                    'tickets' => $tickets,
                ]
            ]);
            return response()->json([$data], 200);
        } catch (Exception $e) {

            return response()->json([
                'status'   => 500,
                'message' =>  $e->getMessage()
            ], 500);
        }
    }
}
