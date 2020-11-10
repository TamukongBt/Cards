<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
   if(isset($_SESSION)){
    if(session()->has('department')){
        $department=session()->get('department');
        $user->assignRole($department);
        return view('welcome');
    }
    else{
        return view('welcome');
    };
   }
   else {
    return view('welcome');
   }
    
    
});

Route::resource('cards','CardsController');
Route::resource('branch', 'BranchController');
Route::resource('request','RequestController');
Route::get('request/confirm/{id}', 'RequestController@fulfilled');
Route::get('roles', 'RoleController@sysrole');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
