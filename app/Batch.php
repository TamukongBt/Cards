<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $fillable = ['start_acct','end_acct','batch_number','done_by'];
}
