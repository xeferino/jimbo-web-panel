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
        $action = Action::insert([
            'title'         => 'Nueva Venta',
            'description'   => 'se ha creado una venta '.Helper::amount($sale->amout),
            'user_id'       => $sale->user_id ?? $sale->seller_id,
            'created_at'    => now()
        ]);
    }
}
