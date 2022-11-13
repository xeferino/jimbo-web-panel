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
        foreach (Winner::where('raffle_id', $id)->orderBy('amount','DESC')->get() as $key => $value) {

            $country = Country::find($value->country_id);

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
                    'amount'               => Helper::amount($value->amount),
                    'ticket_id_parent'     => $value->Ticket->serial,
                    'ticket_id_winner'     => $value->TicketWinner->serial,
                    'seller_id'            => $value->seller_id,
                    'user_id'              => $value->user_id,
                    'raffle_id'            => $value->raffle_id,
                    'created_at'           => $value->created_at,
                    'image'                => $image,
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
