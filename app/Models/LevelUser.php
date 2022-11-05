<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LevelUser extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function Level()
    {
        return $this->belongsTo('App\Models\Level');
    }
}
