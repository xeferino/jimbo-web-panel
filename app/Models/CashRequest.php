<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashRequest extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function User()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function AccountUser()
    {
        return $this->belongsTo('App\Models\AccountUser', 'account_user_id', 'id');
    }
}
