<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\FormFavoriteRequest;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Models\Raffle;
use App\Models\FavoriteDraw;
use App\Helpers\Helper;
use App\Models\Ticket;

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
                'raffles.id',
                'raffles.title',
                'raffles.cash_to_draw',
                'raffles.date_start',
                'raffles.date_end',
                'raffles.date_release',
                DB::raw("TIMESTAMPDIFF(DAY, now(), raffles.date_end) AS remaining_days"),
                DB::raw("CONCAT('".$this->asset."',raffles.image) AS logo"))
                ->where('raffles.active', 1)
                ->where('raffles.public', 1)
                ->whereNull('raffles.deleted_at')
                ->orderBy('raffles.id', 'DESC')
                ->get();

            if($request->user) {
                $raffles = Raffle::select(
                    'raffles.id',
                    'raffles.title',
                    'raffles.cash_to_draw',
                    'raffles.date_start',
                    'raffles.date_end',
                    'raffles.date_release',
                    DB::raw("TIMESTAMPDIFF(DAY, now(), raffles.date_end) AS remaining_days"),
                    DB::raw("CONCAT('".$this->asset."',raffles.image) AS logo"))
                    ->leftjoin('favorite_draws', 'raffles.id', '=', 'favorite_draws.raffle_id')
                    ->leftjoin('users', 'users.id', '=', 'favorite_draws.user_id')
                    ->where('users.id', $request->user)
                    ->whereNull('favorite_draws.deleted_at')
                    ->orderBy('raffles.id', 'DESC')
                    ->get();
            }

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
            $raffle = Raffle::findOrFail($id);
            $data = [];
            $tickets = [];

            foreach ($raffle->tickets as $key => $value) {
                array_push($tickets, [
                    'id'            => $value->id,
                    'serial'        => $value->serial,
                    'promotion_id'  => $value->promotion_id,
                    'raffle_id'     => $value->raffle_id,
                    'quantity'      => $value->quantity,
                    'total'         => $value->total,
                    'promotions'    => [
                        'id'        => $value->promotion->id,
                        'name'      => $value->promotion->name,
                        'code'      => $value->promotion->code,
                        'price'     => Helper::amount($value->promotion->price),
                        'quantity'  => $value->promotion->quantity,
                        'active'    => $value->promotion->active,
                        'available' => ($value->quantity>0) ? true : false
                    ]
                ]);
            }

            array_push($data, [
                'raflle' => [
                    'id'            => $raffle->id,
                    'title'         => $raffle->title,
                    'description'   => $raffle->description,
                    'brand'         => $raffle->brand,
                    'promoter'      => $raffle->promoter,
                    'place'         => $raffle->place,
                    'provider'      => $raffle->provider,
                    'cash_to_draw'  => Helper::amount($raffle->cash_to_draw),
                    'logo'          => $raffle->image != 'raffle.jpg' ? $this->asset.$raffle->image : $this->asset.'raffle.jpg',
                    'date_start'    => $raffle->date_start->format('d/m/Y'),
                    'date_end'      => $raffle->date_end->format('d/m/Y'),
                    'date_release'  => $raffle->date_release->format('d/m/Y'),
                    'days_extend'   => $raffle->days_extend != null ? $raffle->days_extend : 'No hay dias de prorroga',
                    'active'        => $raffle->active,
                    'public'        => $raffle->public,
                    'type'          => ($raffle->type == 'raffle') ? 'Sorteo' : 'Producto',
                    'awards' => [
                        'first'     => Helper::amount(($raffle->cash_to_draw*$raffle->prize_1)/100),
                        'second'    => Helper::amount(($raffle->cash_to_draw*$raffle->prize_2)/100),
                        'third'     => Helper::amount(($raffle->cash_to_draw*$raffle->prize_3)/100),
                        'fourth'    => Helper::amount(($raffle->cash_to_draw*$raffle->prize_4)/100),
                        'fifth'     => Helper::amount(($raffle->cash_to_draw*$raffle->prize_5)/100),
                        'sixth'     => Helper::amount(($raffle->cash_to_draw*$raffle->prize_6)/100),
                        'seventh'   => Helper::amount(($raffle->cash_to_draw*$raffle->prize_7)/100),
                        'eighth'    => Helper::amount(($raffle->cash_to_draw*$raffle->prize_8)/100),
                        'nineth'    => Helper::amount(($raffle->cash_to_draw*$raffle->prize_9)/100),
                        'tenth'     => Helper::amount(($raffle->cash_to_draw*$raffle->prize_10)/100),
                    ],
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ticket(Request $request)
    {
        try {
            $ticket = Ticket::where('id',  $request->ticket_id)
            ->where('raffle_id', $request->raffle_id)
            ->where('promotion_id', $request->promotion_id)
            ->first();

            $data = [];

            if($ticket) {
                array_push($data, [
                    'raflle' => [
                        'id'            => $ticket->raffle->id,
                        'title'         => $ticket->raffle->title,
                        'description'   => $ticket->raffle->description,
                        'brand'         => $ticket->raffle->brand,
                        'promoter'      => $ticket->raffle->promoter,
                        'place'         => $ticket->raffle->place,
                        'provider'      => $ticket->raffle->provider,
                        'cash_to_draw'  => Helper::amount($ticket->raffle->cash_to_draw),
                        'logo'          => $ticket->raffle->image != 'raffle.jpg' ? $this->asset.$ticket->raffle->image : $this->asset.'raffle.jpg',
                        'date_start'    => $ticket->raffle->date_start->format('d/m/Y'),
                        'date_end'      => $ticket->raffle->date_end->format('d/m/Y'),
                        'date_release'  => $ticket->raffle->date_release->format('d/m/Y'),
                        'days_extend'   => $ticket->raffle->days_extend != null ? $ticket->raffle->days_extend : 'No hay dias de prorroga',
                        'active'        => $ticket->raffle->active,
                        'public'        => $ticket->raffle->public,
                        'type'          => ($ticket->raffle->type == 'raffle') ? 'Sorteo' : 'Producto',
                        'promotion' => [
                            'id'        => $ticket->promotion->id,
                            'name'      => $ticket->promotion->name,
                            'code'      => $ticket->promotion->code,
                            'price'     =>Helper::amount($ticket->promotion->price),
                            'quantity'  => $ticket->promotion->quantity,
                        ],
                    ]
                ]);
            }
            return response()->json([$data], 200);
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
    public function store(FormFavoriteRequest $request)
    {
        try {
            $favorite = FavoriteDraw::where('user_id', $request->user_id)
            ->where('raffle_id', $request->raffle_id)
            ->whereNull('deleted_at')
            ->first();

            if($favorite) {
                $delete = $favorite->delete();
                    if ($delete)
                        return response()->json([
                            'status'    => 200,
                            'success'   => true,
                            'message'   =>  'Sorteo eliminado de favoritos',
                        ], 200);
            }

            $favorite = FavoriteDraw::insert([
                'user_id'   => $request->user_id,
                'raffle_id' => $request->raffle_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if($favorite)
                return response()->json([
                    'status'    => 200,
                    'success'   => true,
                    'message'   =>  'Sorteo agregado como favorito',
                ], 200);
        }catch (Exception $e) {
            return response()->json([
                'status'   => 500,
                'message' =>  $e->getMessage()
            ]);
        }
    }
}
