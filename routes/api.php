<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/shifts', 'App\Api\Shift\ShiftController@index');
Route::get('/hours', 'App\Api\Time\TimeController@hours');
Route::get('/bonusminutes', 'App\Api\Time\TimeController@bonusMinutes');
