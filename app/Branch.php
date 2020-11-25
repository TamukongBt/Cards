<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = ['name','branch_code'];

  public function requests(){

     return $this->hasMany('App\Request', 'branch_id', 'branch_code');

  }
}
