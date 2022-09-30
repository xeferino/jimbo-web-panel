<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];


    public function Raffle()
    {
        return $this->belongsTo('App\Models\Raffle');
    }

    public function Promotion()
    {
        return $this->belongsTo('App\Models\Promotion');
    }
}
