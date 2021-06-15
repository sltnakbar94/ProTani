<?php
//KTP
Route::get('/province' , 'Api\Common\ProvinceController@index');
Route::get('/province/{id}' , 'Api\Common\ProvinceController@show');
Route::get('/regency' , 'Api\Common\RegencyController@index');
Route::get('/regency/{id}' , 'Api\Common\RegencyController@show');
Route::get('/district' , 'Api\Common\DistrictController@index');
Route::get('/district/{id}' , 'Api\Common\DistrictController@show');
Route::get('/village' , 'Api\Common\VillageController@index');
Route::get('/village/{id}' , 'Api\Common\VillageController@show');

//Lokasi Kolam
Route::get('/province2' , 'Api\Common\ProvinceController2@index');
Route::get('/province2/{id}' , 'Api\Common\ProvinceController2@show');
Route::get('/regency2' , 'Api\Common\RegencyController2@index');
Route::get('/regency2/{id}' , 'Api\Common\RegencyController2@show');
Route::get('/district2' , 'Api\Common\DistrictController2@index');
Route::get('/district2/{id}' , 'Api\Common\DistrictController2@show');
Route::get('/village2' , 'Api\Common\VillageController2@index');
Route::get('/village2/{id}' , 'Api\Common\VillageController2@show');
