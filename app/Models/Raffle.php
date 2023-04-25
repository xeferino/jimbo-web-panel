<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use App\Models\Winner;
use App\Helpers\Helper;

class Raffle extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function Tickets()
    {
        return $this->hasMany('App\Models\Ticket');
    }

    public function ExtendsDate()
    {
        return $this->hasMany('App\Models\ExtendGiveaway', 'raffle_id', 'id');
    }

    public function totalSale()
    {
        return $this->hasMany('App\Models\Sale', 'raffle_id', 'id');
    }

    public function TicketUser()
    {
        return $this->hasMany('App\Models\TicketUser', 'raffle_id', 'id');
    }

    public static function Winners($id)
    {
        $winners = [];
        $winner = null;
        foreach (Winner::where('raffle_id', $id)->orderBy('amount','DESC')->get() as $key => $value) {

            $country = Country::find($value->country_id);
            $raffle = Raffle::find($value->raffle_id);

            if((($raffle->prize_1*$raffle->cash_to_draw)/100) == $value->amount) {
                $winner = 1;
            }else if((($raffle->prize_2*$raffle->cash_to_draw)/100) == $value->amount) {
                $winner = 2;
            }else if((($raffle->prize_3*$raffle->cash_to_draw)/100) == $value->amount) {
                $winner = 3;
            }else if((($raffle->prize_4*$raffle->cash_to_draw)/100) == $value->amount) {
                $winner = 4;
            }else if((($raffle->prize_5*$raffle->cash_to_draw)/100) == $value->amount) {
                $winner = 5;
            }else if((($raffle->prize_6*$raffle->cash_to_draw)/100) == $value->amount) {
                $winner = 6;
            }else if((($raffle->prize_7*$raffle->cash_to_draw)/100) == $value->amount) {
                $winner = 7;
            }else if((($raffle->prize_8*$raffle->cash_to_draw)/100) == $value->amount) {
                $winner = 8;
            }else if((($raffle->prize_9*$raffle->cash_to_draw)/100) == $value->amount) {
                $winner = 9;
            }else if((($raffle->prize_10*$raffle->cash_to_draw)/100) == $value->amount) {
                $winner = 10;
            }

            $image = config('app.url').'/assets/images/avatar.svg';

            if($value->user_id != null){
                $image = $value->User->image != 'avatar.svg' ? config('app.url').'/assets/images/competitors/'.$value->User->image : config('app.url').'/assets/images/avatar.svg';
            }

            array_push($winners, [
                    'id'                   => $value->id,
                    'name'                 => $value->name,
                    'dni'                  => $value->dni,
                    'phone'                => $value->phone,
                    'email'                => $value->email,
                    'address'              => $value->address,
                    'country_id'           => $value->country_id,
                    'amount'               => Helper::amountJib($value->amount),
                    'amount_usd'           => Helper::amount($value->amount),
                    'prize'                => $value->amount,
                    'ticket_id_parent'     => $value->Ticket->serial,
                    'ticket_id_winner'     => $value->TicketWinner->serial,
                    'seller_id'            => $value->seller_id,
                    'user_id'              => $value->user_id,
                    'raffle_id'            => $value->raffle_id,
                    'status'               => $value->status,
                    'created_at'           => $value->created_at,
                    'image'                => $image,
                    'winner'               => $winner,
                'country'   => [
                    'id'    => $country->id,
                    'name'  => $country->name,
                    'iso'   => $country->iso,
                    'code'  => $country->code,
                    'icon'  => $country->img != 'flag.png' ? config('app.url').'/assets/images/flags/'.$country->img : config('app.url').'/assets/images/flags/flag.png'
                ]
            ]);
        }
        return $winners;
    }

    public function setDateStartAttribute($value):void
    {
        $this->attributes['date_start'] = Carbon::createFromFormat('d/m/Y',$value)->format('Y-m-d');
    }

    public function setDateEndAttribute($value):void
    {
        $this->attributes['date_end'] = Carbon::createFromFormat('d/m/Y',$value)->format('Y-m-d');
    }

    public function setDateReleaseAttribute($value):void
    {
        $this->attributes['date_release'] = Carbon::createFromFormat('d/m/Y',$value)->format('Y-m-d');
    }

    /* public function moneyRaising () {
        $total = \App\Models\Sale::where('raffle_id', $id)->where('status', 'approved')->sum('amount');
        return Helper::amount($total);
    } */

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_start'    => 'datetime:d/m/Y',
        'date_end'      => 'datetime:d/m/Y',
        'date_release'  => 'datetime:d/m/Y',
        'date_extend'   => 'datetime:d/m/Y',
    ];
}
