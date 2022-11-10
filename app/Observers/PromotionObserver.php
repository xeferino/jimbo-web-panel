<?php

namespace App\Observers;

use App\Models\Promotion;
use App\Models\Action;
use Illuminate\Support\Facades\Auth;

class PromotionObserver
{
    /*public $afterCommit = true;*/

    /**
     * Handle the Promotion "created" event.
     *
     * @param  \App\Models\Promotion  $promotion
     * @return void
     */
    public function created(Promotion $promotion)
    {
        $action = Action::insert([
            'title'         => 'Nueva Promocion',
            'description'   => 'se ha creado una promocion '.$promotion->name,
            'user_id'       => Auth::user()->id,
            'created_at'    => now()
        ]);
    }

    /**
     * Handle the Promotion "deleted" event.
     *
     * @param  \App\Models\Promotion  $promotion
     * @return void
     */
    public function deleted(Promotion $promotion)
    {
        $action = Action::insert([
            'title'         => 'Promocion Eliminada',
            'description'   => 'se ha eliminado la promocion '.$promotion->name,
            'user_id'       => Auth::user()->id,
            'created_at'    => now()
        ]);
    }

}
