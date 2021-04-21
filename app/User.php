<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Events\Newuser;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','employee_id','branch_id','department','not_active'
    ];

    protected $dispatchesEvents = [
        'created' => Newuser::class,
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'data' => 'array',

    ];
    // public function branch()
    // {
    //     return $this->belongsTo('App\Branch', 'branch_id', 'branch_code');
    // }

    public function branch()
    {
        return $this->belongsTo('App\Branch', 'branch_id', 'branch_code');
    }

    public function doneby()
    {
        return $this->hasMany('App\Request', 'done_by', 'employee_id');
    }


}
