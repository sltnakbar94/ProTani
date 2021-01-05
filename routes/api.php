<?php

Route::get('/province' , 'Api\Common\ProvinceController@index');
Route::get('/province/{id}' , 'Api\Common\ProvinceController@show');
Route::get('/regency' , 'Api\Common\RegencyController@index');
Route::get('/regency/{id}' , 'Api\Common\RegencyController@show');
Route::get('/district' , 'Api\Common\DistrictController@index');
Route::get('/district/{id}' , 'Api\Common\DistrictController@show');
Route::get('/village' , 'Api\Common\VillageController@index');
Route::get('/village/{id}' , 'Api\Common\VillageController@show');