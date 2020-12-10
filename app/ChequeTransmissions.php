<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChequeTransmissions extends Model
{
    protected $fillable= ['chequeholder','branchcode','remarks'];


    public function branch()
    {
        return $this->belongsTo('App\Branch', 'branchcode', 'branch_code');
    }

}
