<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    // function to create roles that will be used by the system 
    public function sysrole(){
        $csa = Role::create(['name' => 'css']);
        $cards = Role::create(['name'=>'cards']);
        $it= Role::create(['name'=>'it']);
        return view('home');
    }

    // create all the permisions used in the system 
    public function permissions(){
        $edit= Permission::create(['name' => 'edit']);
        $create=Permission::create(['name'=>'create']);
        $delete=Permission::create(['name'=>'delete']);
        $complete=Permission::create(['name'=>'validate']);
        return view('home');
    }

  
}
