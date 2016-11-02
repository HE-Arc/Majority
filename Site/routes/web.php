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

Route::get('/home', 'HomeController@index');

Route::get('/rooms', [
  'middleware' => ['auth'],
  function () {
   return view('rooms');
}]);

Route::get('/createRoom', [
  'middleware' => ['auth'],
  function () {
   return view('createroom');
}]);

Route::get('/game', [
  'middleware' => ['auth'],
  function () {
   return view('game');
}]);