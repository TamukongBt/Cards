<?php

namespace App\Listeners;

use App\User;
use App\Events\Newuser;
use App\Notifications\ValidateUser;
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
        if ($event->user->department == 'branchadmin') {
            $user = User::where('department', 'cards')->get();

            foreach ($user as $card) {
                $card->notify(new ValidateUser($event->user));
            }
        } else  if ($event->user->department == 'cards') {
            $user = User::where('department', 'superadmin')->get();
            foreach ($user as $card) {
                $card->notify(new ValidateUser($event->user));
            }
        } else  if ($event->user->department == 'csa') {
            $user = User::where('department', 'branchadmin')->where('branch_id', $event->user->branch_id)->get();
            foreach ($user as $card) {
                $card->notify(new ValidateUser($event->user));
            }
        }
    }
}
