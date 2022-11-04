<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketUser extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function Ticket()
    {
        return $this->belongsTo('App\Models\Ticket');
    }

}
