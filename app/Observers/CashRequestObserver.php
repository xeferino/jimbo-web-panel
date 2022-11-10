<?php

namespace App\Observers;

use App\Models\CashRequest;
use App\Models\Action;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper;

class CashRequestObserver
{
    /*public $afterCommit = true;*/

    /**
     * Handle the CashRequest "created" event.
     *
     * @param  \App\Models\CashRequest  $cash
     * @return void
     */
    public function created(CashRequest $cash)
    {
        $action = Action::insert([
            'title'         => 'Nueva Solicitud de Efectivo',
            'description'   => 'se ha creado una solicitud de efectivo por el monto '.Helper::amount($cash->amount). ' con la referencia '.$cash->reference,
            'user_id'       => $cash->user_id,
            'created_at'    => now()
        ]);
    }

    public function updated(CashRequest $cash)
    {
        if($cash->status == 'approved'){
            $action = Action::insert([
                'title'         => 'Nuevo Egreso',
                'description'   => 'se ha creado un nuevo egreso por solicitud de efectivo por el monto '.Helper::amount($cash->amount).' con la referencia '.$cash->reference,
                'user_id'       => $cash->user_id,
                'created_at'    => now()
            ]);
        }
    }
}
