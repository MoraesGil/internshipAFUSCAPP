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


Auth::routes();

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');

Route::get('/error/{log}', function ($log) {
  dd(decrypt($log));
});


Route::group(['middleware' => 'auth'], function () {

  Route::get('/clientes', 'ClientController@index')->name('clientes');
  Route::get('/pedidos', 'PedidoController@index')->name('pedidos');


  Route::get('/produtos', 'ProductController@index')->name('produtos');

  Route::group(['prefix' => 'api/produtos', 'as'=>'api.produto.'], function () {
    Route::get('index', ['uses'=>'ProductController@getData', 'as'=>'index']);
    Route::post('store', ['uses'=>'ProductController@store', 'as'=>'store']);
    Route::put('update', ['uses'=>'ProductController@update', 'as'=>'update']);
    Route::delete('delete', ['uses'=>'ProductController@delete', 'as'=>'delete']);
  });
});





Route::get('/logout2', 'Auth\LoginController@logout')->name('logout2');
