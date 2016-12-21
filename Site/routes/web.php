<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/','ListController@show');

Auth::routes();

//Route::get('auth/logout', 'Auth\AuthController@logout');

Route::get('/home', 'HomeController@index');


Route::get('/rooms','RoomController@show');

Route::get('/game','GameController@show');
Route::post('/game','GameController@show');

Route::get('/createRoom', [
  'middleware' => ['auth'],
  function () {
   return view('createroom');
}]);
