<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\FormFavoriteRequest;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Models\Raffle;
use App\Models\FavoriteDraw;
use App\Helpers\Helper;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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
    private function favorites ()
    {
        $raffles = Raffle::select(
            'raffles.id',
            'raffles.title',
            'raffles.cash_to_draw',
            'raffles.date_start',
            'raffles.date_end',
            'raffles.date_release',
            DB::raw("TIMESTAMPDIFF(DAY, now(), raffles.date_end) AS remaining_days"),
            DB::raw("CONCAT('".$this->asset."',raffles.image) AS logo"),
            'type')
            ->where('raffles.active', 1)
            ->where('raffles.public', 1)
            ->where('raffles.finish', 0)
            ->whereNull('raffles.deleted_at')
            ->orderBy('raffles.id', 'DESC')
            ->get();

        $data = [];
        $raffle_favorite = false;
        foreach ($raffles as $key => $value) {
            $favorite = FavoriteDraw::whereNull('deleted_at')
                        ->where('user_id', Auth::user()->id)
                        ->where('raffle_id', $value->id)
                        ->first();

            if($favorite) {
                $raffle_favorite = true;
            }
            # code...
            array_push($data, [
                'id'                => $value->id,
                'title'             => $value->title,
                'cash_to_draw'      => $value->type == 'raffle' ? Helper::amount($value->cash_to_draw) : $value->title,
                'date_start'        => $value->date_start->format('d/m/Y'),
                'date_end'          => $value->date_end->format('d/m/Y'),
                'date_release'      => $value->date_release->format('d/m/Y'),
                'remaining_days'    => $value->remaining_days,
                'logo'              => $value->logo,
                'favorite'          => $raffle_favorite
            ]);
        }

        foreach ($data as $clave => $fila) {
            $id[$clave] = $fila['id'];
            $title[$clave] = $fila['title'];
            $cash_to_draw[$clave] = $fila['cash_to_draw'];
            $date_start[$clave] = $fila['date_start'];
            $date_end[$clave] = $fila['date_end'];
            $date_release[$clave] = $fila['date_release'];
            $remaining_days[$clave] = $fila['remaining_days'];
            $logo[$clave] = $fila['logo'];
            $favorite[$clave] = $fila['favorite'];
        }

        $id  = array_column($data, 'id');
        $favorite = array_column($data, 'favorite');
        array_multisort($favorite, SORT_DESC, $id, SORT_DESC, $data);
        return $data;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            return response()->json(['raffles' => $this->favorites()], 200);
        } catch (Exception $e) {

            return response()->json([
                'status'   => 500,
                'message' =>  $e->getMessage()
            ], 500);
        }
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function winners(Request $request)
    {
        try {
            $raffles = Raffle::select(
                'raffles.id',
                'raffles.title',
                'raffles.cash_to_draw',
                'raffles.date_start',
                'raffles.date_end',
                'raffles.date_release',
                DB::raw("TIMESTAMPDIFF(DAY, raffles.date_release, now()) AS days_ago"),
                DB::raw("CONCAT('".$this->asset."',raffles.image) AS logo"))
                ->where('raffles.active', 0)
                ->where('raffles.public', 1)
                ->where('raffles.finish', 1)
                ->whereNull('raffles.deleted_at')
                ->orderBy('raffles.id', 'DESC')
                ->get();

            $data = [];

            foreach ($raffles as $key => $value) {
                # code...
                array_push($data, [
                    'id'                => $value->id,
                    'title'             => $value->title,
                    'cash_to_draw'      => Helper::amount($value->cash_to_draw),
                    'date_start'        => $value->date_start->format('d/m/Y'),
                    'date_end'          => $value->date_end->format('d/m/Y'),
                    'date_release'      => $value->date_release->format('d/m/Y'),
                    'days_ago'          => $value->days_ago,
                    'logo'              => $value->logo,
                    'winners'           => Raffle::Winners($value->id)
                ]);
            }

            return response()->json(['raffles' => $data], 200);

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
    public function showWinner($id)
    {
        try {
            $raffle = Raffle::findOrFail($id);

            $amount = ((($raffle->cash_to_draw*$raffle->prize_1)/100) +
            (($raffle->cash_to_draw*$raffle->prize_2)/100) +
            (($raffle->cash_to_draw*$raffle->prize_3)/100) +
            (($raffle->cash_to_draw*$raffle->prize_4)/100) +
            (($raffle->cash_to_draw*$raffle->prize_5)/100) +
            (($raffle->cash_to_draw*$raffle->prize_6)/100) +
            (($raffle->cash_to_draw*$raffle->prize_7)/100) +
            (($raffle->cash_to_draw*$raffle->prize_8)/100) +
            (($raffle->cash_to_draw*$raffle->prize_9)/100) +
            (($raffle->cash_to_draw*$raffle->prize_10)/100));
            $percent = (($raffle->totalSale->sum('amount')*100)/($raffle->cash_to_collect-$amount));

            $start =  Carbon::now();
            $end   = Carbon::parse($raffle->date_end);
            $days  = $end->diffInDays($start);

            return response()->json([
                'raflle' => [
                    'id'            => $raffle->id,
                    'title'         => $raffle->title,
                    'description'   => $raffle->description,
                    'brand'         => $raffle->brand,
                    'promoter'      => $raffle->promoter,
                    'place'         => $raffle->place,
                    'provider'      => $raffle->provider,
                    'cash_to_draw'  => $raffle->type == 'raffle' ? Helper::amount($raffle->cash_to_draw) : $raffle->title,
                    'logo'          => $raffle->image != 'raffle.jpg' ? $this->asset.$raffle->image : $this->asset.'raffle.jpg',
                    'date_start'    => $raffle->date_start->format('d/m/Y'),
                    'date_end'      => $raffle->date_end->format('d/m/Y'),
                    'date_release'  => $raffle->date_release->format('d/m/Y'),
                    'active'        => $raffle->active == 1 ? 'Activo' : 'Inactivo',
                    'public'        => $raffle->public == 1 ? 'Publico' : null,
                    'finish'        => $raffle->finish == 1 ? 'Finalizado' : 'Abierto',
                    'type'          => ($raffle->type == 'raffle') ? 'Sorteo' : 'Producto',
                    'days_ago'      => $days,
                    'winners' =>    Raffle::Winners($raffle->id)
                ]
            ], 200);
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
                        'available' => ($value->total>0) ? true : false
                    ]
                ]);
            }

            $amount = ((($raffle->cash_to_draw*$raffle->prize_1)/100) +
            (($raffle->cash_to_draw*$raffle->prize_2)/100) +
            (($raffle->cash_to_draw*$raffle->prize_3)/100) +
            (($raffle->cash_to_draw*$raffle->prize_4)/100) +
            (($raffle->cash_to_draw*$raffle->prize_5)/100) +
            (($raffle->cash_to_draw*$raffle->prize_6)/100) +
            (($raffle->cash_to_draw*$raffle->prize_7)/100) +
            (($raffle->cash_to_draw*$raffle->prize_8)/100) +
            (($raffle->cash_to_draw*$raffle->prize_9)/100) +
            (($raffle->cash_to_draw*$raffle->prize_10)/100));
            $percent = (($raffle->totalSale->sum('amount')*100)/($raffle->cash_to_collect-$amount));

            $start =  Carbon::now();
            $end   = Carbon::parse($raffle->date_end);
            $days  = $end->diffInDays($start);

            return response()->json([
                'raflle' => [
                    'id'                => $raffle->id,
                    'title'             => $raffle->title,
                    'description'       => $raffle->description,
                    'brand'             => $raffle->brand,
                    'promoter'          => $raffle->promoter,
                    'place'             => $raffle->place,
                    'provider'          => $raffle->provider,
                    'cash_to_draw'  => $raffle->type == 'raffle' ? Helper::amount($raffle->cash_to_draw) : $raffle->title,
                    'logo'              => $raffle->image != 'raffle.jpg' ? $this->asset.$raffle->image : $this->asset.'raffle.jpg',
                    'date_start'        => $raffle->date_start->format('d/m/Y'),
                    'date_end'          => $raffle->date_end->format('d/m/Y'),
                    'date_release'      => $raffle->date_release->format('d/m/Y'),
                    'days_extend'       => $raffle->days_extend != null ? $raffle->days_extend : 'No hay dias de prorroga',
                    'active'            => $raffle->active,
                    'public'            => $raffle->public,
                    'type'              => ($raffle->type == 'raffle') ? 'Sorteo' : 'Producto',
                    'progress'          => $percent == 100 ?  100 : sprintf("%.2f", $percent),
                    'remaining_days'    => $days,
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
            ], 200);
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
            return response()->json([
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
            ], 200);
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
                            'raffles'   => $this->favorites(),
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
                    'raffles'   => $this->favorites(),
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
