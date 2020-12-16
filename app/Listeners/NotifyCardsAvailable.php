<?php

namespace App\Listeners;

use App\Events\CardsAvailable;
use App\Transmissions;
use App\Notifications\AvailableNotify;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class NotifyCardsAvailable
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
     * @param  CardsAvailable  $event
     * @return void
     */
    public function handle(CardsAvailable $event)
    {
        $transmissions = Transmissions::where('notified',null);
        foreach($transmissions as $transmission) {
            $transmission->notify(new AvailableNotify($transmission));
            Log::debug('I entered massa.');
           $transmission->notified=1;
           $transmission->notified_on=now();
           $transmission->save();
         }
    }
}
