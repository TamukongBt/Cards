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
Route::group(['middleware' => ['auth']], function () {
    Route::resource('cards','CardsController');
    Route::resource('branch', 'BranchController');
    Route::resource('request','RequestController');
    Route::resource('batch', 'BatchController');
    Route::get('request/confirm/{id}', 'RequestController@fulfilled');
    Route::get('request/data/week', 'RequestController@week');

    Route::get('request/data/', 'RequestController@sortbranch');
    Route::get('request/data/', 'RequestController@sortbranch');
    Route::post('export', 'RequestController@export')->name('export');


});

Route::get('roles', 'RoleController@sysrole');
Route::get('permissions', 'RoleController@permissions');

Route::get('/home', 'HomeController@index')->name('home');
Auth::routes();
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});

Route::group(['middleware' => 'auth'], function () {
	Route::get('{page}', ['as' => 'page.index', 'uses' => 'PageController@index']);
});

