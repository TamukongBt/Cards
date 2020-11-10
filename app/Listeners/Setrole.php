<?php

namespace App\Listeners;

use App\User;
use App\Events\Newuser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;


class Setrole
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Newuser  $event
     * @return void
     */
    public function handle(Newuser $event)
    {
        $event->user->assignRole($event->user->department);
    }
}
