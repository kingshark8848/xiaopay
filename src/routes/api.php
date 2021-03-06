<?php

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

Route::prefix("v1")->group(function (){

    Route::get('/', function (){
        return response()->json(["message"=>"welcome to access XiaoPay API (v1)."]);
    });

    Route::get('/users', 'UserController@list')->name('users.list');
    Route::post('/users', 'UserController@create')->name('users.create');
    Route::get('/users/{user_id}', 'UserController@show')->name('users.show');

    Route::get('/accounts', 'AccountController@list')->name('accounts.list');
    Route::get('/users/{user_id}/accounts', 'AccountController@listOfUser')->name('users.accounts.list');
    Route::post('/users/{user_id}/accounts', 'AccountController@create')->name('users.accounts.create');
});