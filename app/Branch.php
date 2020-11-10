<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = ['name','id'];

  public function requests(){
    
     return $this->hasMany('App\Request', 'branch_id', 'id');
    
  }
}
