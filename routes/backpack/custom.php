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
    Route::get('dashboard/dt-paket-keluar', 'DashboardController@ajaxPaketKeluar')->name('dt.paket-keluar');
    Route::get('dashboard/dt-paket-dikirim', 'DashboardController@ajaxPaketDikirim')->name('dt.paket-dikirim');
    Route::get('dashboard/dt-paket-ditujuan', 'DashboardController@ajaxPaketDitujuan')->name('dt.paket-ditujuan');
    Route::get('dashboard/dt-received', 'DashboardController@ajaxReceived')->name('dt.list-received');
    Route::get('dashboard/{id}/received', 'DashboardController@received')->name('order-received.detail');
    
    Route::get('/', 'AdminController@redirect')->name('backpack');
    Route::crud('tag', 'TagCrudController');
    Route::crud('province', 'ProvinceCrudController');
    Route::crud('regency', 'RegencyCrudController');
    Route::crud('district', 'DistrictCrudController');
    Route::crud('village', 'VillageCrudController');
    Route::crud('faq', 'FaqCrudController');
    Route::crud('notification-user', 'NotificationUserCrudController');
    Route::crud('notification-message', 'NotificationMessageCrudController');

    Route::crud('order', 'OrderCrudController');
    Route::get('order/{id}/dt', 'OrderCrudController@showDatatables')->name('orderdetail.dt');
    Route::crud('orderdetail', 'OrderDetailCrudController');
    Route::post('orderdetail/{id}/manual-scan', 'OrderDetailCrudController@qrManualScan')->name('orderdetail.manual-scan');
    Route::get('orderdetail/{url}/show-qrcode', 'OrderDetailCrudController@showQrCode')->name('orderdetail.show-qrcode');
    Route::crud('order-scan', 'OrderDetailManualCrudController');
    Route::crud('produksi', 'ProduksiCrudController');
    
    Route::get('exportall', 'ExportExcelController@export_excel');
    Route::get('exportexcel', 'ExportExcelController@show')->name('export.show');

    Route::crud('recipient', 'RecipientCrudController');
    Route::crud('download', 'DownloadCrudController');
    Route::crud('expedition', 'ExpeditionCrudController');
    Route::crud('destination', 'DestinationCrudController');
    Route::crud('company', 'CompanyCrudController');
    Route::crud('downloadorder', 'DownloadOrderCrudController');
    Route::crud('recipient-manual', 'RecipientManualCrudController');
}); // this should be the absolute last line of this file