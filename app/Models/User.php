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
use App\Models\LevelUser;
use App\Helpers\Helper;


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
        'names',
        'surnames',
        'dni',
        'phone',
        'email',
        'address',
        'address_city',
        'password',
        'active',
        'country_id',
        'image',
        'code',
        'code_referall',
        'type',
        'become_seller',
        'balance_usd',
        'balance_jib',
        'seller_at'
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

    public function Cards()
    {
        return $this->hasMany('App\Models\CardUser', 'user_id', 'id');
    }

    public function Sales()
    {
        return $this->hasMany('App\Models\Sale', 'seller_id', 'id');
    }

    public function Shoppings()
    {
        return $this->hasMany('App\Models\Sale', 'user_id', 'id');
    }

    public function Referals()
    {
        return $this->hasMany('App\Models\LevelUser', 'referral_id', 'id');
    }

    public static function Guests($id)
    {
        $guests = [];
        foreach (LevelUser::where('referral_id', $id)->get() as $key => $referral) {
            array_push($guests, [
                'id'                => $referral->id,
                'user_id'           => $referral->seller_id,
                'fullnames'         => $referral->User->names. ' ' .$referral->User->surnames,
                'email'             => $referral->User->email,
                'phone'             => $referral->User->phone,
                'address_city'      => $referral->User->address_city,
                'address'           => $referral->User->address,
                'image'             => $referral->User->image != 'avatar.svg' ? config('app.url').'/assets/images/competitors/'.$referral->User->image : config('app.url').'/assets/images/avatar.svg',
                'level'             => $referral->Level->name ?? '----',
                'sales'             => $referral->User->sales->count(),
                'amount_sale'       => Helper::amount($referral->User->sales->sum('amount')),
                'country'      => [
                    'id'    => $referral->User->country->id,
                    'name'  => $referral->User->country->name,
                    'iso'   => $referral->User->country->iso,
                    'code'  => $referral->User->country->code,
                    'icon'  => $referral->User->country->img != 'flag.png' ? config('app.url').'/assets/images/flags/'.$referral->User->country->img : config('app.url').'/assets/images/flags/flag.png'
                ]
            ]);
        }
        return $guests;
    }

    public function Accounts()
    {
        return $this->hasMany('App\Models\AccountUser', 'user_id', 'id');
    }

    public function Customer()
    {
        return $this->hasOne('App\Models\Customer'::class);
    }

    public function LevelSeller()
    {
        return $this->hasOne('App\Models\LevelUser'::class, 'seller_id', 'id');
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
