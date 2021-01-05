<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['web']], function(){
    Route::redirect('/', '/admin/dashboard');
    Route::redirect('/home', '/admin/dashboard');
    Route::get('/check-point/{url}/submit', 'Admin\OrderDetailCrudController@showForm')->name('qrcode-form');
    Route::post('/check-point/{url}/submit', 'Admin\OrderDetailCrudController@submitForm')->name('qrcode-submit');
    Route::get('/check-point/{url}/show', 'Admin\OrderDetailCrudController@successForm')->name('qrcode-show-data');

    Route::get('/partisipasi', 'Admin\RecipientCrudController@showForm')->name('recipient-form');
    Route::post('/partisipasi', 'Admin\RecipientCrudController@submitForm')->name('recipient-submit');
});