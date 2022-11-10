<?php

namespace App\Observers;

use App\Models\Country;
use App\Models\Action;
use Illuminate\Support\Facades\Auth;

class CountryObserver
{
    /*public $afterCommit = true;*/

    /**
     * Handle the Country "created" event.
     *
     * @param  \App\Models\Country  $country
     * @return void
     */
    public function created(Country $country)
    {
        $action = Action::insert([
            'title'         => 'Nuevo Pais',
            'description'   => 'se ha creado un pais '.$country->name,
            'user_id'       => Auth::user()->id,
            'created_at'    => now()
        ]);
    }

    /**
     * Handle the Country "deleted" event.
     *
     * @param  \App\Models\Country  $country
     * @return void
     */
    public function deleted(Country $country)
    {
        $action = Action::insert([
            'title'         => 'Pais Eliminado',
            'description'   => 'se ha eliminado el pais '.$country->name,
            'user_id'       => Auth::user()->id,
            'created_at'    => now()
        ]);
    }
}
