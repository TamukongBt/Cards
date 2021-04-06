<?php

namespace App\Mail;

use App\CheckRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Cheque extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $transmissions;

    public function __construct(CheckRequest $transmissions)
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
        ->subject('Chequebook Available')->markdown('chequemail')->with([
            'branch' => $this->transmissions['branchcode']
        ]);
    }
}
