<?php

use App\Http\Controllers\API\MessageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', 'App\Http\Controllers\API\UserController@login');
Route::post('register', 'App\Http\Controllers\API\UserController@register');

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('user/token', 'App\Http\Controllers\API\UserController@token');
    Route::post('logout', 'App\Http\Controllers\API\UserController@logout');
    Route::get('messages', [MessageController::class, 'allMessages']);
    Route::post('sendmessage', [MessageController::class, 'sendMessage']);
});
