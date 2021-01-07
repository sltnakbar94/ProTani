<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', config('backpack.base.middleware_key', 'admin'), 'user.active'],
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::get('dashboard', 'AdminController@dashboard')->name('backpack.dashboard');
    Route::get('dashboard-map', 'AdminController@dashboardMap')->name('backpack.dashboard-map');

    Route::get('/', 'AdminController@redirect')->name('backpack');
    Route::crud('tag', 'TagCrudController');
    Route::crud('province', 'ProvinceCrudController');
    Route::crud('regency', 'RegencyCrudController');
    Route::crud('district', 'DistrictCrudController');
    Route::crud('village', 'VillageCrudController');
    Route::crud('faq', 'FaqCrudController');
    Route::crud('notification-user', 'NotificationUserCrudController');
    Route::crud('notification-message', 'NotificationMessageCrudController');

    Route::crud('salesform', 'SalesFormCrudController');
    Route::crud('salesformdetail', 'SalesFormDetailCrudController');
    Route::crud('downloadsalesform', 'DownloadSalesFormCrudController');
}); // this should be the absolute last line of this file
