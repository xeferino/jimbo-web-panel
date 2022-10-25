<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class ExtendGiveaway extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function setDateEndBacktAttribute($value):void
    {
        $this->attributes['date_end_back'] = Carbon::createFromFormat('d/m/Y',$value)->format('Y-m-d');
    }

    public function setDatereleaseBacktAttribute($value):void
    {
        $this->attributes['date_release_back'] = Carbon::createFromFormat('d/m/Y',$value)->format('Y-m-d');
    }

    public function setDatereleaseNexttAttribute($value):void
    {
        $this->attributes['date_release_next'] = Carbon::createFromFormat('d/m/Y',$value)->format('Y-m-d');
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_end_back'         => 'datetime:d/m/Y',
        'date_release_back'     => 'datetime:d/m/Y',
        'date_release_next'     => 'datetime:d/m/Y',
    ];
}
