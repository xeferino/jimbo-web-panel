<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Sale extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function Raffle()
    {
        return $this->belongsTo('App\Models\Raffle');
    }

    public function Country()
    {
        return $this->belongsTo('App\Models\Country');
    }

    public function Ticket()
    {
        return $this->belongsTo('App\Models\Ticket');
    }

    public function User()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function Buyer()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function Seller()
    {
        return $this->belongsTo('App\Models\User', 'seller_id', 'id');
    }

    public function TicketsUsers()
    {
        return $this->hasMany('App\Models\TicketUser', 'sale_id', 'id');
    }

    /* public function getCreatedAtAttribute($value):void
    {
        $this->attributes['created_at'] = Carbon::createFromFormat('Y-m-d  H:i:s',$value)->format('d/m/Y H:i:s');
    } */

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    /* protected $casts = [
        'created_at'    => 'datetime:d/m/Y H:i:s',
    ]; */
}
