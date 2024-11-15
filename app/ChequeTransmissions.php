<?php

namespace App;
use App\Events\ChequeAvailable;
use Illuminate\Database\Eloquent\Model;

class ChequeTransmissions extends Model
{
    protected $fillable= ['chequeholder','branchcode','remarks','email','phone_number'];

    protected $dispatchesEvents = [
        'created' => ChequeAvailable::class,
    ];


    public function branch()
    {
        return $this->belongsTo('App\Branch', 'branchcode', 'branch_code');
    }
    public function reqholder()
    {
        return $this->belongsTo('App\Requested', 'chequeholder', 'accountname');
    }
    public function reqbranch()
    {
        return $this->belongsTo('App\Branch', 'branchcode', 'branch_id');
    }

}
