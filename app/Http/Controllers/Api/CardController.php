<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\FormCardRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Models\CardUser as Card;

class CardController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $cards = Card::where('user_id', $request->user)->get();

            return response()->json([
                'status'  => 200,
                'cards'   =>  $cards
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
            $card = Card::findOrFail($request->card);

            return response()->json([
                'status'  => 200,
                'card'   =>  $card
            ], 200);
        }catch (Exception $e) {
            return response()->json([
                'status'   => 500,
                'message' =>  $e->getMessage()
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FormCardRequest $request)
    {
        try {
            $card               = new Card();
            $card->bank         = $request->bank;
            $card->number       = $request->number;
            $card->type         = $request->type;
            $card->code         = $request->code;
            $card->date_expire  = $request->date_expire;
            $card->user_id      = $request->user_id;

            $saved = $card->save();
            if($saved)
                return response()->json(['success' => true, 'message' => 'Tarjeta agregada exitosamente.'], 200);
        } catch (Exception $e) {
            return response()->json([
                'status'   => 500,
                'message' =>  $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FormCardRequest $request, Card $Card)
    {
        try {
            $card               = Card::findOrFail($Card->id);
            $card->bank         = $request->bank;
            $card->number       = $request->number;
            $card->type         = $request->type;
            $card->code         = $request->code;
            $card->date_expire  = $request->date_expire;
            $update = $card->save();

            if($update)
                return response()->json(['success' => true, 'message' => 'La tarjeta ha sido actualizada exitosamente.'], 200);
        } catch (Exception $e) {
            return response()->json([
                'status'   => 500,
                'message' =>  $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $card = Card::findOrFail($id);
            $delete = $card->delete();
            if ($delete)
                return response()->json(['success' => true, 'message' => 'Tarjeta eliminada exitosamente.'], 200);
        } catch (Exception $e) {
            return response()->json([
                'status'   => 500,
                'message' =>  $e->getMessage()
            ], 500);
        }
    }
}
