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

Route::middleware('web', 'authh', 'auth', 'SetSessionData', 'language', 'timezone', 'AdminSidebarMenu')->prefix('licitacion')->group(callback: function() {
    Route::get('/', 'LicitacionController@index');

    Route::get('/install', [Modules\Licitacion\Http\Controllers\InstallController::class, 'index']);
    Route::post('/install', [Modules\Licitacion\Http\Controllers\InstallController::class, 'install']);
    Route::get('/install/uninstall', [Modules\Licitacion\Http\Controllers\InstallController::class, 'uninstall']);
    Route::get('/install/update', [Modules\Licitacion\Http\Controllers\InstallController::class, 'update']);

    Route::resource('dashboard', 'Modules\Licitacion\Http\Controllers\DashboardController');
    Route::resource('', 'Modules\Licitacion\Http\Controllers\LicitacionController');
    Route::get('/dataTable',[Modules\Licitacion\Http\Controllers\LicitacionController::class, 'getDraftDatables']);
});
