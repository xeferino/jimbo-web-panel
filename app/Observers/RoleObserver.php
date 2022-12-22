<?php

namespace App\Observers;

use Spatie\Permission\Models\Role;
use App\Models\Action;
use Illuminate\Support\Facades\Auth;

class RoleObserver
{
    /*public $afterCommit = true;*/

    /**
     * Handle the Role "created" event.
     *
     * @param  \App\Models\Role  $role
     * @return void
     */
    public function created(Role $role)
    {
        if (Auth::check()) {
            $action = Action::insert([
                'title'         => 'Nuevo Rol',
                'description'   => 'se ha creado un Rol '.$role->name,
                'user_id'       => Auth::user()->id,
                'created_at'    => now()
            ]);
        }
    }

    /**
     * Handle the Role "deleted" event.
     *
     * @param  \App\Models\Role  $role
     * @return void
     */
    public function deleted(Role $role)
    {
        if (Auth::check()) {
            $action = Action::insert([
                'title'         => 'Rol Eliminado',
                'description'   => 'se ha eliminado el Rol '.$role->name,
                'user_id'       => Auth::user()->id,
                'created_at'    => now()
            ]);
        }
    }
}
