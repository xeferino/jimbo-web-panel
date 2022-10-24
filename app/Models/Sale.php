<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function Raffle()
    {
        return $this->belongsTo('App\Models\Raffle');
    }

    public function Ticket()
    {
        return $this->belongsTo('App\Models\Ticket');
    }

    public function TicketsUsers()
    {
        return $this->hasMany('App\Models\TicketUser', 'sale_id', 'id');
    }
}
