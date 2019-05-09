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

Route::resource('consultores', 'ConsultoresController');

Route::post('get_relatorio', 'ConsultoresController@get_relatorio');
Route::get('get_relatorio1', 'ConsultoresController@get_relatorio1');

Route::post('pizza_data', 'ConsultoresController@get_pizza_data');
Route::get('pizza_data1', 'ConsultoresController@get_pizza_data1');

Route::post('grafico_data', 'ConsultoresController@get_grafico_data');
Route::get('grafico_data1', 'ConsultoresController@get_grafico_data1');
