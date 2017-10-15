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

Route::get('/error/{log}', function ($log) {
  dd(decrypt($log));
});



Route::group(['middleware' => 'auth'], function () {

  Route::get('/', 'HomeController@index')->name('home');
  Route::get('/home', 'HomeController@index');


  Route::group([
    'prefix' => 'movimentacoes',
    'as'=>'mov.'
  ], function() {
    Route::get('/', 'MovimentacoesController@index');
  });



  Route::group([
    'prefix' => 'movimento',
    'as'=>'mov.'
  ], function() {
    Route::resource('/movimentacoes', 'MovimentacoesController', ['except' => ['create', 'edit', 'show']]);
  });

  Route::group([
    'prefix' => 'movimento',
    'as'=>'cat.'
  ], function() {
    Route::resource('/categorias', 'CategoriaController', ['except' => ['create', 'edit', 'show']]);
  });

});




Route::get('/logout2', 'Auth\LoginController@logout')->name('logout2');
