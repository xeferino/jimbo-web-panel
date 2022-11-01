<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\FormCardRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\CulqiService as Culqi;
use Exception;
use App\Models\CardUser as Card;
use App\Models\User;

class CardController extends Controller
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
        $this->asset = config('app.url').'/assets/images/methods/';
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
            $cards = [];
            foreach (Card::where('user_id', $request->user)->get() as $key => $value) {
                # code...
                array_push($cards, [
                    'id'=> $value->id,
                    'name'=> $value->number,
                    'icon'=> $this->asset.$value->icon,
                    'type'=> $value->type,
                    'valid'=> $value->deleted_at == null ? true : false
                ]);
            }

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FormCardRequest $request)
    {
        try {
            $user = User::findOrFail($request->user_id);
            $expire = explode('/',$request->date_expire);
            //token de la tarjeta a validar y crear la tarjeta en culqi
            $card = [
                'card_number'       => $request->number,
                'cvv'               => $request->code,
                'expiration_month'  => $expire[0],
                'expiration_year'   => $expire[1],
                'email'             => $user->email,
                'metadata' => [
                    'fullname'       => $user->names. ' ' .$user->surnames,
                    'phone'          => $user->phone,
                    'dni'            => $user->dni,
                    'address'        => $user->address,
                    'address_city'   => $user->address_city
                ]
            ];

            $culqi = new Culqi($card);
            $data = [
                "customer_id" => $user->customer->culqi_customer_id,
                'validate'    => true
            ];

            $card = $culqi->card($data);
            $object = $card->object ?? 'error';

            if($object == 'card') {
                $cardUser                       = new Card();
                $cardUser->number               = $card->source->card_number;
                $cardUser->type                 = 'card';//$card->source->iin->card_type;
                $cardUser->brand                = $card->source->iin->card_brand;
                $cardUser->culqi_card_id        = $card->id;
                $cardUser->culqi_token_id       = $card->source->id;
                $cardUser->culqi_customer_id    = $user->customer->culqi_customer_id == $card->customer_id ? $card->customer_id : $user->customer->culqi_customer_id;
                $cardUser->default              = 0;
                $cardUser->user_id              = $user->id;
                $cardUser->icon                 = 'card.png';
                $saved = $cardUser->save();
            } else {
                $customer = json_decode($card, true);
                return response()->json([
                    'error'     => true,
                    'type'      => $customer['type'],
                    'message'   => $customer['merchant_message']]);
            }

            $cards = [];
            foreach (Card::where('user_id', $user->id)->get() as $key => $value) {
                # code...
                array_push($cards, [
                    'id'=> $value->id,
                    'name'=> $value->number,
                    'icon'=> $value->icon,
                    'type'=> $value->type,
                    'valid'=> $value->deleted_at == null ? true : false
                ]);
            }
            if($saved)
                return response()->json([
                    'success' => true,
                    'message' => 'Tarjeta agregada exitosamente.',
                    'card'    => $cardUser,
                    'cards'   => $cards
                ], 200);
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
            $culqi = new Culqi();
            $card = Card::findOrFail($id);
            $culqiCard = $culqi->deleteCard($card->culqi_cardUser_id);

            if ($culqiCard->getStatusCode() == 200){
                $delete = $card->delete();
                if ($delete)
                    return response()->json(['success' => true, 'message' => 'Tarjeta eliminada exitosamente.'], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'status'   => 500,
                'message' =>  $e->getMessage()
            ], 500);
        }
    }
}
