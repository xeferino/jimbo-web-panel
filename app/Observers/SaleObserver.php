<?php

namespace App\Observers;

use App\Models\Sale;
use App\Models\Action;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper;

class SaleObserver
{
    /*public $afterCommit = true;*/

    /**
     * Handle the Sale "created" event.
     *
     * @param  \App\Models\Sale  $sale
     * @return void
     */
    public function created(Sale $sale)
    {
        $user_id = null;
        if(isset($sale->user_id) &&  $sale->user_id){
            $user_id =$sale->user_id;
        } elseif(isset($sale->seller_id) &&  $sale->seller_id){
            $user_id =$sale->seller_id;
        }

        $action = Action::insert([
            'title'         => 'Nueva Venta',
            'description'   => 'se ha creado una venta '.Helper::amount($sale->amount). ' con la referencia '.$sale->number,
            'user_id'       => $user_id,
            'created_at'    => now()
        ]);
    }
}
