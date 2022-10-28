<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\PaymentController;
use Illuminate\Http\Request;
use App\Http\Requests\Api\FormSaleRequest;
use App\Models\CardUser as Card;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Models\Slider;
use App\Models\Ticket;
use App\Models\Sale as Shopping;
use App\Models\TicketUser;
use App\Models\User;

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
            $shoppings = Shopping::where('user_id', $request->user)->where('status', 'approved')->get();

            return response()->json([
                'status'  => 200,
                'shoppings'   =>  $shoppings
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
                    'status' => $shopping->Raffle->active,
                    'code_ticket' => $shopping->Ticket->serial,
                    'tickets' => $shopping->TicketsUsers,
                    'date_start' => $shopping->Raffle->date_end->format('d/m/y'),
                    'date_end' => $shopping->Raffle->date_end->format('d/m/y'),
                    'date_release' => $shopping->Raffle->date_release != null ? $shopping->Raffle->date_release->format('d/m/y') : null,
                    'date_extend' => $shopping->Raffle->date_extend,
                ],
                'quantity' => $shopping->quantity,
                'amount' => $shopping->amount,
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
                'status'   => 500,
                'message' =>  $e->getMessage()
            ]);
        }
    }

}
