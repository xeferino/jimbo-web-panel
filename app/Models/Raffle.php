<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

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
