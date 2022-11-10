<?php

namespace App\Observers;

use App\Models\Raffle;
use App\Models\Action;
use Illuminate\Support\Facades\Auth;

class RaffleObserver
{
    /*public $afterCommit = true;*/

    /**
     * Handle the Raffle "created" event.
     *
     * @param  \App\Models\Raffle  $raffle
     * @return void
     */
    public function created(Raffle $raffle)
    {
        $action = Action::insert([
            'title'         => 'Nuevo Sorteo',
            'description'   => 'se ha creado un sorteo '.$raffle->title,
            'user_id'       => Auth::user()->id,
            'created_at'    => now()
        ]);
    }

    /**
     * Handle the Raffle "deleted" event.
     *
     * @param  \App\Models\Raffle  $raffle
     * @return void
     */
    public function deleted(Raffle $raffle)
    {
        $action = Action::insert([
            'title'         => 'Sorteo Eliminado',
            'description'   => 'se ha eliminado el sorteo '.$raffle->title,
            'user_id'       => Auth::user()->id,
            'created_at'    => now()
        ]);
    }

}
