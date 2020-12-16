<?php

namespace App\Listeners;

use App\Events\ChequeAvailable;
use App\ChequeTransmissions;
use App\Notifications\AvailableChequeNotify;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyChequeAvailable
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
     * @param  ChequeAvailable  $event
     * @return void
     */
    public function handle(ChequeAvailable $event)
    {
        $ChequeTransmissions = ChequeTransmissions::where('notified',null);
        foreach($ChequeTransmissions as $transmission) {
            $transmission->notify(new AvailableChequeNotify($transmission));
           $transmission->notified=1;
           $transmission->notified_on=now();
           $transmission->save();
         }
    }
}
