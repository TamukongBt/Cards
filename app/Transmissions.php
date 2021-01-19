<?php

namespace App;

use App\Events\CardsAvailable;
use Illuminate\Database\Eloquent\Model;

class Transmissions extends Model
{
    protected $fillable= ['cardholder','card_type','branchcode','card_number','remarks','phone_number','email'];

    protected $dispatchesEvents = [
        'created' => CardsAvailable::class,
    ];


    public function branch()
    {
        return $this->belongsTo('App\Branch', 'branchcode', 'branch_code');
    }
public function cardtype()
    {
        return $this->belongsTo('App\Cards', 'cards', 'card_type');
    }

    public function reqcard()
    {
        return $this->belongsTo('App\Requested', 'card_type', 'card_type');
    }
    public function reqbranch()
    {
        return $this->belongsTo('App\Branch', 'branchcode', 'branch_id');
    }
    public function routeNotificationForNexmo($notification)
    {
        return $this->phone_number;
    }
}
