<?php

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

// `Route::group(['prefix' => 'v1'], function(){
//     Route::group(['prefix' => 'merchant'], function(){
//         Route::group(['prefix' => 'auth', 'namespace' => 'Api\V1\Merchant'], function ($router) {
//             Route::post('login', 'AuthController@login');
//             Route::post('logout', 'AuthController@logout');
//             Route::get('me', 'AuthController@me');
//             Route::post('me', 'AuthController@updateMe');
//             Route::post('refresh', 'AuthController@refresh');
//         });

//         /**
//          * Module Endpoints
//          */
//         Route::group(['namespace' => 'Api\V1\Merchant', 'middleware' => 'auth:merchant'], function ($router) {
//             Route::resource('user', 'UserController');
//             Route::resource('dashboard', 'DashboardController');
//         });
//     });
// });`