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

  Route::get('/', 'HomeController@index');

Route::group(['middleware' => 'auth'], function () {

  Route::group([
    'prefix' => 'movimentacoes',
  ], function() {

     Route::get('/', 'MovimentacoesController@getData');

  });



  Route::get('/home', 'HomeController@index');

});





Route::get('/logout2', 'Auth\LoginController@logout')->name('logout2');
