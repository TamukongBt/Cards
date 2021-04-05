<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CardRequest extends Model
{
    protected $casts = [
        'data' => 'array',
            'created_at' => 'date'
    ];

    protected $fillable = ['branch_id','accountname','account_number','bankcode','branchcode','RIB','cards','account_type',
    'request_type','done_by','accountname','requested_by','email','tel','card_number'];

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
        return $this->belongsTo('App\Cards', 'cards', 'card_type');
    }
}
