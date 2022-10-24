<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FavoriteDraw extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function Raffles()
    {
        return $this->belongsTo('App\Models\Raffle');
    }

    public function User()
    {
        return $this->belongsTo('App\Models\User');
    }
}
