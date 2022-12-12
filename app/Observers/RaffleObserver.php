<?php

namespace App\Observers;

use App\Models\Raffle;
use App\Models\Action;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\NotificationController;

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
     * Handle the Raffle "updated" event.
     *
     * @param  \App\Models\Raffle  $raffle
     * @return void
     */
    public function updated(Raffle $raffle)
    {
        $users = User::whereIn('type', [1,2])->where('active', 1)->get();
        foreach ($users as $key => $user) {
            if($raffle->active == 1 && $raffle->public == 1 && $raffle->finish == 0){
                NotificationController::store('Nuevo sorteo!', 'se ha generado un nuevo sorteo para ti! '.$raffle->title.', finaliza '.$raffle->date_end->format('d/m/Y').'', $user->id);
            }
        }
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
