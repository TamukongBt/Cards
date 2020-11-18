<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Requested extends Model
{
    protected $fillable = ['employee_id','branch_id','account_number','cards','account_type','request_type','done_by','account_name','requested_by'];
}
