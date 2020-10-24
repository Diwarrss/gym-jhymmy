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
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
  Route::get('/home/{any?}', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

  //usuarios
  Route::resource('user', 'App\Http\Controllers\UserController');
  //generos
  Route::resource('genders', 'App\Http\Controllers\GenderController');
  //estados
  Route::resource('states', 'App\Http\Controllers\StateController');
  //seguimineto
  Route::resource('follow', 'App\Http\Controllers\TracingController');
  //pagos
  Route::resource('payments', 'App\Http\Controllers\PaymentController');
  //perfil
  Route::resource('profiles', 'App\Http\Controllers\ProfileController');
  //acceso
  Route::resource('accesses', 'App\Http\Controllers\AccessControlController');
  //motivo de cancelación
  Route::resource('cancellationReason', 'App\Http\Controllers\CancellationReasonController');

	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::get('upgrade', function () {return view('pages.upgrade');})->name('upgrade');
  Route::get('map', function () {return view('pages.maps');})->name('map');
  Route::get('icons', function () {return view('pages.icons');})->name('icons');
  Route::get('table-list', function () {return view('pages.tables');})->name('table');
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});

