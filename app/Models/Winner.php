<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Winner extends Model
{
    use HasFactory;

    public function User()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function Ticket()
    {
        return $this->belongsTo('App\Models\Ticket');
    }

    public function TicketWinner()
    {
        return $this->belongsTo('App\Models\TicketUser', 'ticket_user_id', 'id');
    }
}
