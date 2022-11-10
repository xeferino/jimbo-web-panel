<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Action;
use Illuminate\Support\Facades\Auth;

class UserObserver
{
    /*public $afterCommit = true;*/

    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        $title          = '';
        $description    = '';
        $user_id        = null;
        if($user->type == 2){
            $title          = 'Nuevo Vendedor';
            $description    = 'se ha creado una nueva cuenta de vendedor para '.$user->email.', para el pais ' .$user->Country->name;
            $user_id        = Auth::user()->id;
        }elseif($user->type == 1){
            $title          = 'Nuevo Usuario';
            $description = 'oh! '.$user->email.', se acaba de registrar en jimbo sorteos, desde '.$user->Country->name;
        } else {
            $title          = 'Nuevo Colaborador';
            $description    = 'se ha creado una nueva cuenta de colaborador para '.$user->email;
            $user_id        = Auth::user()->id;
        }
        $action = Action::insert([
            'title'         => $title,
            'description'   => $description,
            'user_id'       => $user_id,
            'created_at'    => now()
        ]);
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        $title          = '';
        $description    = '';
        $user_id        = null;
        if($user->type == 2){
            $title          = 'Vendedor Eliminado';
            $description    = 'se ha eliminado la nueva cuenta de vendedor para '.$user->email.', para el pais ' .$user->Country->name;
            $user_id        = Auth::user()->id;
        }elseif($user->type == 1){
            $title          = 'Usuario Eliminado';
            $description    = 'se ha eliminado la cuenta de participante para '.$user->email.', para el pais ' .$user->Country->name;
            $user_id        = Auth::user()->id;
        } else {
            $title          = 'Colaborador Eliminado';
            $description    = 'se ha eliminado la cuenta del colaborado para '.$user->email;
            $user_id        = Auth::user()->id;
        }
        $action = Action::insert([
            'title'         => $title,
            'description'   => $description,
            'user_id'       => $user_id,
            'created_at'    => now()
        ]);
    }
}
