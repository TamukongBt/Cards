<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    // function to create roles that will be used by the system
    public function sysrole(){
        $super = Role::create(['name' => 'superadmin']);
        $cards = Role::create(['name'=>'cards']);
        $csa= Role::create(['name'=>'csa']);
        $branchadmin= Role::create(['name'=>'branchadmin']);
        $dso = Role::create(['name'=>'dso']);

        return redirect(route('permissions'));
    }


    // create all the permisions used in the system
    public function permissions(){

        $edit= Permission::create(['name' => 'edit']);
        $create=Permission::create(['name'=>'create']);
        $delete=Permission::create(['name'=>'delete']);
        $complete=Permission::create(['name'=>'validate']);
        $download=Permission::create(['name'=>'download']);

        $csa=Role::findByName('superadmin');
        $csa->givePermissionTo('create');
        $csa->givePermissionTo('delete');
        $csa->givePermissionTo('edit');

        $branchadmin=Role::findByName('branchadmin');
        $branchadmin->givePermissionTo('create');
        $branchadmin->givePermissionTo('delete');
        $branchadmin->givePermissionTo('edit');

        $css=Role::findByName('csa');
        $css->givePermissionTo('create');
        $css->givePermissionTo('delete');
        $css->givePermissionTo('edit');

        $cards=Role::findByName('cards');
        $cards->givePermissionTo('download');
        $cards->givePermissionTo('edit');

        $dso=Role::findByName('dso');
        $dso->givePermissionTo('download');
        return view('pages.dashboard')->with('success','Roles Created');
    }





}
