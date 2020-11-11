<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $fillable = ['account_type','employee_id','branch_id','number','cards','account_type','request_type','done_by'];

    
}
