<?php

namespace App;

use DateTime;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $fillable = ['start_acct','end_acct','batch_number','done_by'];



    protected $casts = [
        'created_at' => 'date'
    ];
}
