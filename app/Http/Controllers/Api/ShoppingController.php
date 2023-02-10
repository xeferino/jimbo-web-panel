<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use App\Models\Sale as Shopping;
use App\Models\User;
use App\Helpers\Helper;

class ShoppingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $shoppings = Shopping::where('user_id', $request->user)->where('status', 'approved')->orderBy('created_at','DESC')->get();

            $data = [];

            foreach ($shoppings as $key => $value) {
                # code...
               array_push($data, [
                   "id" => $value->id,
                   "name" =>  $value->name,
                   "dni" =>  $value->dni,
                   "phone" =>  $value->phone,
                   "email" =>  $value->email,
                   "address" =>  $value->address,
                   "country_id" =>  $value->country_id,
                   "amount" =>  Helper::amountJib($value->amount),
                   "number" =>  $value->number,
                   "number_culqi" =>  $value->number_culqi,
                   "quantity" =>  $value->quantity,
                   "ticket_id" =>  $value->ticket_id,
                   "seller_id" =>  $value->seller_id,
                   "user_id" =>  $value->user_id,
                   "raffle_id" =>  $value->raffle_id,
                   "status" => $value->status == 'approved' ? 'Aprodada' : 'Rechazada',
                   "date"  => $value->created_at->format('d/m/y'),
                   "hour"  => $value->created_at->format('H:i:s'),
                   "created_at" => $value->created_at->format('d/m/Y H:i:s')
               ]);
            }

            return response()->json([
                'status'  => 200,
                'shoppings'   =>  $data
            ], 200);
        }catch (Exception $e) {
            return response()->json([
                'status'   => 500,
                'message' =>  $e->getMessage()
            ]);
        }
    }

    /**
     * Display a single of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        try {
            $shopping = Shopping::findOrFail($request->shopping);
            $shopping = [
                'raffle' => [
                    'title' => $shopping->Raffle->title,
                    'first_prize'  => $shopping->Raffle->type == 'raffle' ?  Helper::amountJib($shopping->Raffle->cash_to_draw) : $shopping->Raffle->title,
                    'status' => $shopping->Raffle->active == 1 ? 'Activo' : 'Inactivo',
                    'finish' => $shopping->Raffle->finish == 1 ? 'Finalizado' : 'Abierto',
                    'code_ticket' => $shopping->Ticket->serial,
                    'tickets' => $shopping->TicketsUsers,
                    'date_start' => $shopping->Raffle->date_end->format('d/m/y'),
                    'date_end' => $shopping->Raffle->date_end->format('d/m/y'),
                    'date_release' => $shopping->Raffle->date_release != null ? $shopping->Raffle->date_release->format('d/m/y') : null,
                    'date_extend' => $shopping->Raffle->date_extend,
                ],
                'quantity' => $shopping->quantity,
                'amount' => Helper::amountJib($shopping->amount),
                'number_operation' => $shopping->number,
                'date'  => $shopping->created_at->format('d/m/y'),
                'hour'  => $shopping->created_at->format('H:i:s')
            ];
            return response()->json([
                'status'   => 200,
                'shopping' => $shopping
            ], 200);
        }catch (Exception $e) {
            return response()->json([
                'status'  => 500,
                'message' =>  $e->getMessage()
            ]);
        }
    }


    /**
     * Display a single graphics of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function graphics(Request $request)
    {
        try {
            $jib = User::whereHas("roles", function ($q) {
                $q->whereIn('name', ['competitor']);
            })
            ->join('sales', 'sales.user_id', '=', 'users.id' )
            ->whereNull('users.deleted_at')->where('users.active', 1)
            ->whereMonth('sales.created_at', date('m'))
            ->where('sales.status', 'approved')
            ->where('sales.method', 'jib')
            ->where('sales.user_id', $request->user)
            ->count();

            $card = User::whereHas("roles", function ($q) {
                $q->whereIn('name', ['competitor']);
            })
            ->join('sales', 'sales.user_id', '=', 'users.id' )
            ->whereNull('users.deleted_at')->where('users.active', 1)
            ->whereMonth('sales.created_at', date('m'))
            ->where('sales.status', 'approved')
            ->where('sales.method', 'card')
            ->where('sales.user_id', $request->user)
            ->count();

            $labels  = ['Jib', 'Tarjeta', 'Plin', 'Yape'];
            $data   = [$jib, $card, 0, 0];

            return response()->json([
                'grafics' => [
                    'sales' => [
                        'labels' => $labels,
                        'data' => $data,
                    ]
                ],
                'status'   => 200
            ], 200);

        }catch (Exception $e) {
            return response()->json([
                'status'  => 500,
                'message' =>  $e->getMessage()
            ]);
        }
    }

}
