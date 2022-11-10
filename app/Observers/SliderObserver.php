<?php

namespace App\Observers;

use App\Models\Slider;
use App\Models\Action;
use Illuminate\Support\Facades\Auth;

class SliderObserver
{
    /*public $afterCommit = true;*/

    /**
     * Handle the Slider "created" event.
     *
     * @param  \App\Models\Slider  $slider
     * @return void
     */
    public function created(Slider $slider)
    {
        $action = Action::insert([
            'title'         => 'Nuevo Slider',
            'description'   => 'se ha creado un slider de imagen '.$slider->name,
            'user_id'       => Auth::user()->id,
            'created_at'    => now()
        ]);
    }

    /**
     * Handle the Slider "deleted" event.
     *
     * @param  \App\Models\Slider  $slider
     * @return void
     */
    public function deleted(Slider $slider)
    {
        $action = Action::insert([
            'title'         => 'Slider Eliminado',
            'description'   => 'se ha eliminado el slider de imagen '.$slider->name,
            'user_id'       => Auth::user()->id,
            'created_at'    => now()
        ]);
    }
}
