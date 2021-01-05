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

// Route::group(['prefix' => 'v1'], function(){
//     Route::group(['prefix' => 'customer'], function(){
//         Route::group(['prefix' => 'auth', 'namespace' => 'Api\V1\Customer'], function ($router) {
//             Route::post('login', 'AuthController@login');
//             Route::post('logout', 'AuthController@logout');
//             Route::get('me', 'AuthController@me');
//             Route::post('me', 'AuthController@updateMe');
//             Route::post('refresh', 'AuthController@refresh');
//             Route::post('password', 'PasswordController@update');
//             Route::post('social', 'SocialAuthController@extractToken');
//         });
//         /**
//          * For Public
//          */
//         Route::group(['namespace' => 'Api\V1\Customer'], function ($router) {
//             Route::get('faq', 'FaqController@index');
//             Route::get('faq/{slug}', 'FaqController@show');
//             Route::get('page', 'PageController@index');
//             Route::get('page/{slug}', 'PageController@show');
//         });
//     });
// });