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
    Route::resource('cardrequest','CardRequestController');
    Route::resource('checkrequest','CheckRequestController');
    Route::resource('batch', 'BatchController');
    Route::resource('slots', 'SlotsController');
    Route::resource('transmissions', 'TransmissionsController');
    Route::resource('cheque', 'ChequeTransmissionsController');

// Custom Views
Route::get('/cardvalidated', 'CardRequestController@validated')->name('request.approved');
Route::get('/check_subscriptions', 'CheckRequestController@production')->name('checkrequest.production');
Route::get('/subscriptions', 'CardRequestController@sproduction')->name('cardrequest.sproduction');
Route::get('/renewals', 'CardRequestController@rproduction')->name('cardrequest.rproduction');
Route::get('/cardrejected', 'CardRequestController@rejected')->name('request.rejected');
Route::get('/checkvalidated', 'CheckRequestController@validated')->name('crequest.approved');
Route::get('/checkapproves', 'CheckRequestController@approves')->name('crequest.approves');
Route::get('/checkrejected', 'CheckRequestController@rejected')->name('crequest.rejected');
Route::get('/collected', 'TransmissionsController@collected')->name('transmissions.collected');
Route::get('/pinindex', 'TransmissionsController@pinindex')->name('transmissions.pinindex');
Route::get('/collectedpin', 'TransmissionsController@pin')->name('transmissions.collectedpin');
Route::get('/ccollected', 'ChequeTransmissionsController@collected')->name('cheque.collected');
Route::get('/change', 'ProfileController@change');

// Ajax request for index
    Route::get('/changes', 'ProfileController@change1');
    Route::get('/cards_ajax','CardsController@index1');
    Route::get('/branch_ajax', 'BranchController@index1');
    Route::get('/slots_ajax', 'SlotsController@index1');
    Route::get('/batch_ajax', 'BatchController@index1');
    Route::get('/transmissions_ajax', 'TransmissionsController@index1');
    Route::get('/ctransmissions_ajax', 'ChequeTransmissionsController@index1');
    Route::get('/ajax', 'CardRequestController@index1');
    Route::get('/checkajax', 'CheckRequestController@index1');
    Route::get('/validated_ajax', 'CardRequestController@validated1');
    Route::get('/rejected_ajax', 'CardRequestController@rejected1');
    Route::get('/production_ajax', 'CheckRequestController@production1');
    Route::get('/sproduction_ajax', 'CardRequestController@sproduction1');
    Route::get('/rproduction_ajax', 'CardRequestController@rproduction1');
    Route::get('/checkvalidated_ajax', 'CheckRequestController@validated1');
    Route::get('/checkrejected_ajax', 'CheckRequestController@rejected1');
    Route::get('/checkapproves_ajax', 'CheckRequestController@approves1');
    Route::get('/view_ajax', 'BatchController@view1');
    Route::get('/read_ajax', 'CardRequestController@markread');
    Route::get('/checkread_ajax', 'CheckRequestController@markread');
    Route::get('/collect_ajax', 'TransmissionsController@collected1');
    Route::get('/ajax_pin', 'TransmissionsController@pinindex1');
    Route::get('/ajax_collectedpin', 'TransmissionsController@pin1');
    Route::get('/ccollect_ajax', 'ChequeTransmissionsController@collected1');
    Route::get('/autosearch', 'CardRequestController@selectSearch');
    Route::get('/autosearch2', 'CheckRequestController@selectSearch');



// validate actions
    // Request
    Route::get('cardrequest/confirm/{id}', 'CardRequestController@fulfilled');
    Route::get('checkrequest/confirm/{id}', 'CheckRequestController@fulfilled');
    Route::get('checkrequest/confirm/{id}', 'CheckRequestController@fulfilled');
    Route::get('batch/view/{id}', 'BatchController@view')->name('batch.view');
    Route::get('request/approve/{id}', 'CardRequestController@approved');
    Route::post('cardrequest/reject/{id}', 'CardRequestController@denied');
    Route::get('card/track/{id}', 'CardRequestController@track');
    Route::get('check/track/{id}', 'CheckRequestController@track');
    Route::get('checkrequest/approve/{id}', 'CheckRequestController@approved');
    Route::post('checkrequest/reject/{id}', 'CheckRequestController@denied');
    Route::post('/transmissions/collected/{id}', 'TransmissionsController@collect');
    Route::post('/transmissions/collectpin/{id}', 'TransmissionsController@collectpin');
    Route::post('/cheque/collected/{id}', 'ChequeTransmissionsController@collect');
    // Slots
    Route::get('slots/confirm/{id}', 'SlotsController@fulfilled');
    Route::get('slots/reject/{id}', 'SlotsController@denied');

    // dashboard ajax data

    Route::get('/week', 'CardRequestController@newcardcount');
    Route::get('/week', 'CheckRequestController@newcardcount');
    Route::get('/stock', 'TransmissionsController@count');
    Route::get('/overdue', 'TransmissionsController@overdue');
    Route::get('/newcards', 'CardRequestController@newcards');
    Route::get('/renew', 'CardRequestController@renew');
    Route::get('/newcardbranch', 'CardRequestController@newcardbranch');
    Route::get('/other_ajax', 'CardRequestController@other');
    Route::get('/checknewcards', 'CheckRequestController@newcards');
    Route::get('/checkrenew', 'CheckRequestController@renew');
    Route::get('/checknewcardbranch', 'CheckRequestController@newcardbranch');
    Route::get('/checkother_ajax', 'CheckRequestController@other');
    Route::get('/slotso', 'SlotsController@slotso');
    Route::get('/slotsed', 'SlotsController@slotsed');
    Route::get('/batch1', 'BatchController@batch1');
    Route::get('/validatedcount', 'CardRequestController@validatedcount');

    Route::get('/validatedcountit', 'CardRequestController@validatedcountit');
    Route::get('/groupcount', 'CardRequestController@groupvalidated');
    Route::get('/rejectedcount', 'CardRequestController@rejectedcount');
    Route::get('/pendingcount', 'CardRequestController@pendingcount');
    Route::get('/checkvalidatedcount', 'CheckRequestController@validatedcount');
    Route::get('/checkvalidatedcountit', 'CheckRequestController@validatedcountit');
    Route::get('/checkgroupcount', 'CheckRequestController@groupvalidated');
    Route::get('/checkrejectedcount', 'CheckRequestController@rejectedcount');
    Route::get('/checkpendingcount', 'CheckRequestController@pendingcount');


    // Custom Sorts
    Route::get('request/data/', 'CardRequestController@sortbranch');
    Route::post('export', 'CardRequestController@export')->name('export');
    Route::post('export', 'CardRequestController@export')->name('export');
    Route::post('exportrejects', 'CardRequestController@exportrejected')->name('export.rejects');
    Route::post('exportsubs', 'CardRequestController@exportsubs')->name('export.subs');
    Route::post('exportrenewals', 'CardRequestController@exportrenewals')->name('export.renewals');
    Route::post('exportchecks', 'CheckRequestController@exportchecks')->name('export.checks');
    Route::post('exportcollected', 'TransmissionsController@exportcollected')->name('export.collected');
    Route::get('request/data/', 'CardRequestController@sortbranch');
    Route::post('export', 'CardRequestController@export')->name('export');
    Route::post('export', 'CardRequestController@export')->name('export');
    Route::post('exportrejects', 'CardRequestController@exportrejected')->name('export.rejects');
    Route::post('exportsubs', 'CardRequestController@exportsubs')->name('export.subs');

    Route::get('checkrequest/data/', 'CheckRequestController@sortbranch');
    Route::post('checkexport', 'CheckRequestController@export')->name('export');
    Route::post('checkexport', 'CheckRequestController@export')->name('export');
    Route::post('checkexportrejects', 'CheckRequestController@exportrejected')->name('cexport.rejects');
    Route::post('checkexportsubs', 'CheckRequestController@exportsubs')->name('cexport.subs');
    Route::post('exportcollected', 'TransmissionsController@exportcollected')->name('cexport.collected');
    Route::get('checkrequest/data/', 'CheckRequestController@sortbranch');
    Route::post('checkexport', 'CheckRequestController@export')->name('export');
    Route::post('checkexport', 'CheckRequestController@export')->name('export');
    Route::post('checkexportrejects', 'CheckRequestController@exportrejected')->name('cexport.rejects');
    Route::post('checkexportsubs', 'CheckRequestController@exportsubs')->name('cexport.subs');

    Route::post('exportcollected', 'TransmissionsController@exportcollected')->name('export.collected');
    Route::post('exportccollected', 'ChequeTransmissionsController@exportccollected')->name('export.ccollected');

    Route::get('/location/confirm/{id}', 'ProfileController@approve')->name('profile.approve');
    Route::put('profile/notify',  'ProfileController@notify')->name('profile.notify');

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

