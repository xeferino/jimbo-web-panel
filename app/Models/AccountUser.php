<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountUser extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];


    public function User()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function CashRequest()
    {
        return $this->hasMany('App\Models\CashRequest', 'account_user_id', 'id');
    }
}
