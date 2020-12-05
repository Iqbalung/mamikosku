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
    
    Route::name('kost')->get('kost', 'Service\KostController@read');

    Route::middleware(['auth:api'])->group(function () {
    
        Route::name('kost')->post('kost', 'Service\KostController@create');
        Route::name('kost/{id}')->put('kost/{id}', 'Service\KostController@update');
        Route::name('kost/{id}')->get('kost/{id}', 'Service\KostController@find');
        Route::name('kost/{id}')->delete('kost/{id}', 'Service\KostController@delete');

        Route::name('credit')->post('credit', 'Service\CreditController@create');
        Route::name('credit/{id}')->put('credit/{id}', 'Service\CreditController@update');
        Route::name('credit/{id}')->get('credit/{id}', 'Service\CreditController@find');
        Route::name('credit')->get('credit', 'Service\CreditController@read');
        Route::name('credit/{id}')->delete('credit/{id}', 'Service\CreditController@delete');

    });
});
