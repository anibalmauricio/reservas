<?php

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

Route::get('/home', 'HomeController@index')->name('home');
Route::apiResource('reserva', 'API\ReservaController');

Route::get('reservas', 'ReservasController@index')->name('reservas');

Route::get('detail/{id}', 'ReservasController@edit')->where('id', '[0-9]+')->name('mostrarReserva');