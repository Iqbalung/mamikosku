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

Route::prefix('v1')->group(function () {
    
	//Registration
    Route::name('user/registration')->post('user/registration', 'Auth\RegisterController@create');
    Route::name('user/registration')->get('user/registration', 'Auth\RegisterController@read');
    Route::name('user/registration/{id}')->put('user/registration/{id}', 'Auth\RegisterController@update');
    Route::name('user/registration/{id}')->delete('user/registration/{id}', 'Auth\RegisterController@delete');
    Route::name('user/registration/{id}')->get('user/registration/{id}', 'Auth\RegisterController@find');
    Route::name('user/verification/{id}')->put('user/verification/{id}', 'Auth\RegisterController@verification');

    //Registration
    Route::name('login')->post('login', 'Auth\LoginController@authenticate');
});
