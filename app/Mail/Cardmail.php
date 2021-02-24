<?php

namespace App\Mail;

use App\Transmissions;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Cardmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $transmissions;

    public function __construct(Transmissions $transmissions)
    {
         $this->transmissions = $transmissions;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this ->from('cards@unionbankcameroon.com', 'UBC Plc')
        ->subject('Bank Card Available')->markdown('cardmail') ->with([
            'branch' => $this->transmissions['branchcode']
        ]);
    }
}
