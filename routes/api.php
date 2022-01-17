<?php

use App\Http\Controllers\User\UserDataController;
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


Route::group([
    'prefix' => 'v1.0',
    'middleware' => 'api'
], function ($router) {
    Route::group(
        ['prefix' => 'auth'],
        function ($router) {

            Route::post("login", 'User\UserController@login')->name('login');
            Route::post("register/start", 'User\RegistrationController@createUser');

            Route::post("register/complete", "User\RegistrationController@completeUserCreation");
            Route::get("password/forgot/{phone_number}", "User\UserController@forgotPassword");
            Route::post("password/reset", "User\UserController@resetPassword");
            Route::get("refresh", "User\UserController@refresh");
            Route::get("logout", "User\UserController@logout");
        }
    );

    Route::post("verify/otp", "User\RegistrationController@verifyRegisterOTP");
    Route::get("country", "User\RegistrationController@country");
    Route::get("state/{country_id}", "User\RegistrationController@state");
    Route::get("city/{state_id}", "User\RegistrationController@city");

    Route::group(['middleware' => 'auth:api'], function ($router) {
        Route::post("user/details", [UserDataController::class, 'getUserDetails']);
    });
});
