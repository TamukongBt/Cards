<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transmissions extends Model
{
    protected $fillable= ['cardholder','card_type','branchcode','card_number','remarks'];


    public function branch()
    {
        return $this->belongsTo('App\Branch', 'branchcode', 'branch_code');
    }
public function cardtype()
    {
        return $this->belongsTo('App\Cards', 'cards', 'card_type');
    }
}
