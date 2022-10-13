<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Mail\ResetPassword;
use Illuminate\Support\Facades\Mail;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    protected $fillable = [
        'name',
        'dni',
        'phone',
        'email',
        'password',
        'active',
        'image',
        'code',
        'balance_usd',
        'balance_jib',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function Country()
    {
        return $this->belongsTo('App\Models\Country');
    }

    public function Actions()
    {
        return $this->hasMany('App\Models\Action');
    }

    public function Notifications()
    {
        return $this->hasMany('App\Models\Notification');
    }


    /**
     * Send a password reset notification to the user.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $url = route('password.reset', $token) . '?email=' . $this->email;
        Mail::to($this)->queue(new ResetPassword($url, $this->email));
    }
}
