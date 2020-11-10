<?php

use App\Http\Controllers\CancellationReasonController;
use App\Http\Controllers\GenderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\TracingController;
use App\Http\Controllers\UserController;
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
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
  Route::get('/home/{any?}', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

  //usuarios
  Route::resource('users', UserController::class);
  Route::put('users-state/{id}', [App\Http\Controllers\UserController::class, 'updateState']);

  //generos
  Route::resource('genders', GenderController::class);
  Route::put('genders-state/{id}', [App\Http\Controllers\GenderController::class, 'updateState']);

  //estados
  Route::resource('states', StateController::class);
  Route::put('states-state/{id}', [App\Http\Controllers\StateController::class, 'updateState']);

  //seguimineto
  Route::resource('tracings', TracingController::class);
  Route::put('tracings-state/{id}', [App\Http\Controllers\TracingController::class, 'updateState']);

  //pagos
  Route::resource('payments', PaymentController::class);
  Route::put('payments-state/{id}', [App\Http\Controllers\PaymentController::class, 'updateState']);

  //perfil
  //Route::resource('profiles', 'App\Http\Controllers\ProfileController');

  //acceso
  Route::resource('access-controlls', 'App\Http\Controllers\AccessControlController');
  //Route::put('access-cancel/{id}', [App\Http\Controllers\GenderController::class, 'updateState']);

  //motivo de cancelación
  Route::resource('cancellation-reasons', CancellationReasonController::class);
  Route::put('cancellation-reasons-state/{id}', [App\Http\Controllers\CancellationReasonController::class, 'updateState']);

	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::get('upgrade', function () {return view('pages.upgrade');})->name('upgrade');
  Route::get('map', function () {return view('pages.maps');})->name('map');
  Route::get('icons', function () {return view('pages.icons');})->name('icons');
  Route::get('table-list', function () {return view('pages.tables');})->name('table');
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});

