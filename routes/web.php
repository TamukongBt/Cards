<?php

use App\Slots;
use GuzzleHttp\Psr7\Request;
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
    return view('pages/dashboard');
});
Route::group(['middleware' => ['auth']], function () {
    Route::resource('cards','CardsController');
    Route::resource('branch', 'BranchController');
    Route::resource('request','RequestedController');
    Route::resource('batch', 'BatchController');
    Route::resource('slots', 'SlotsController');
    Route::resource('transmissions', 'TransmissionsController');
    Route::resource('cheque', 'ChequeTransmissionsController');

// Custom Views
Route::get('/validated', 'RequestedController@validated')->name('request.approved');
Route::get('/approves', 'RequestedController@approves')->name('request.approves');
Route::get('/rejected', 'RequestedController@rejected')->name('request.rejected');
Route::get('/collected', 'TransmissionsController@collected')->name('transmissions.collected');
Route::get('/pinindex', 'TransmissionsController@pinindex')->name('transmissions.pinindex');
Route::get('/collectedpin', 'TransmissionsController@pin')->name('transmissions.collectedpin');
Route::get('/ccollected', 'ChequeTransmissionsController@collected')->name('cheque.collected');


// Ajax request for index

    Route::get('/cards_ajax','CardsController@index1');
    Route::get('/branch_ajax', 'BranchController@index1');
    Route::get('/slots_ajax', 'SlotsController@index1');
    Route::get('/batch_ajax', 'BatchController@index1');
    Route::get('/transmissions_ajax', 'TransmissionsController@index1');
    Route::get('/ctransmissions_ajax', 'ChequeTransmissionsController@index1');
    Route::get('/ajax', 'RequestedController@index1');
    Route::get('/validated_ajax', 'RequestedController@validated1');
    Route::get('/rejected_ajax', 'RequestedController@rejected1');
    Route::get('/approves_ajax', 'RequestedController@approves1');
    Route::get('/view_ajax', 'BatchController@view1');
    Route::get('/read_ajax', 'RequestedController@markread');
    Route::get('/collect_ajax', 'TransmissionsController@collected1');
    Route::get('/ajax_pin', 'TransmissionsController@pinindex1');
    Route::get('/ajax_collectedpin', 'TransmissionsController@pin1');
    Route::get('/ccollect_ajax', 'ChequeTransmissionsController@collected1');
    Route::get('/autosearch', 'BatchController@selectSearch');


// validate actions
    // Request
    Route::get('request/confirm/{id}', 'RequestedController@fulfilled');
    Route::get('batch/view/{id}', 'BatchController@view')->name('batch.view');
    Route::get('request/approve/{id}', 'RequestedController@approved');
    Route::post('request/reject/{id}', 'RequestedController@denied');
    Route::post('/transmissions/collected/{id}', 'TransmissionsController@collect');
    Route::post('/transmissions/collectpin/{id}', 'TransmissionsController@collectpin');
    Route::post('/cheque/collected/{id}', 'ChequeTransmissionsController@collect');
    // Slots
    Route::get('slots/confirm/{id}', 'SlotsController@fulfilled');
    Route::get('slots/reject/{id}', 'SlotsController@denied');

    // dashboard ajax data

    Route::get('/week', 'RequestedController@newcardcount');
    Route::get('/stock', 'TransmissionsController@count');
    Route::get('/overdue', 'TransmissionsController@overdue');
    Route::get('/newcards', 'RequestedController@newcards');
    Route::get('/renew', 'RequestedController@renew');
    Route::get('/newcardbranch', 'RequestedController@newcardbranch');
    Route::get('/other_ajax', 'RequestedController@other');
    Route::get('/slotso', 'SlotsController@slotso');
    Route::get('/slotsed', 'SlotsController@slotsed');
    Route::get('/batch1', 'BatchController@batch1');
    Route::get('/validatedcount', 'RequestedController@validatedcount');
    Route::get('/validatedcountit', 'RequestedController@validatedcountit');
    Route::get('/groupcount', 'RequestedController@groupvalidated');
    Route::get('/rejectedcount', 'RequestedController@rejectedcount');
    Route::get('/pendingcount', 'RequestedController@pendingcount');


    // Custom Sorts
    Route::get('request/data/', 'RequestedController@sortbranch');
    Route::post('export', 'RequestedController@export')->name('export');
    Route::post('export', 'RequestedController@export')->name('export');
    Route::post('exportrejects', 'RequestedController@exportrejected')->name('export.rejects');
    Route::post('exportapproved', 'RequestedController@exportapproved')->name('export.approved');
    Route::post('exportcollected', 'TransmissionsController@exportcollected')->name('export.collected');
    Route::post('exportccollected', 'ChequeTransmissionsController@exportccollected')->name('export.ccollected');



});

Route::get('roles', 'RoleController@sysrole');
Route::get('alerts', 'TransmissionsController@alerts');

Route::get('permissions', 'RoleController@permissions')->name('permissions');

Route::get('/home', 'HomeController@index')->name('home');
Auth::routes();

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});

Route::group(['middleware' => 'auth'], function () {
	Route::get('{page}', ['as' => 'page.index', 'uses' => 'PageController@index']);
});

