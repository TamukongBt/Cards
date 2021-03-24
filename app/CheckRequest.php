<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CheckRequest extends Model
{
    protected $casts = [
        'data' => 'array',
            'created_at' => 'date'
    ];

    protected $fillable = ['employee_id','branch_id','account_number','bankcode','branchcode','RIB','chequetype','account_type',
    'request_type','done_by','account_name','requested_by','email','tel'];

    public function branch()
    {
        return $this->belongsTo('App\Branch', 'branch_id', 'branch_code');
    }

    public function requesttype()
    {
        return $this->belongsTo('App\Request_type', 'request_type', 'request_code');
    }

    public function cardtype()
    {
        return $this->belongsTo('App\Cards', 'chequetype', 'card_type');
    }
}
