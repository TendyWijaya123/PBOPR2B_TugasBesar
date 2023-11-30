<?php

use App\Http\Controllers\AkunController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MakananController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['prefix' => 'dashboard/admin'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::group(['prefix' => 'profile'], function () {
        Route::get('/', [HomeController::class, 'profile'])->name('profile');
        Route::post('update', [HomeController::class, 'updateprofile'])->name('profile.update');
    });

    Route::controller(AkunController::class)
        ->prefix('akun')
        ->as('akun.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('showdata', 'dataTable')->name('dataTable');
            Route::match(['get','post'],'tambah', 'tambahAkun')->name('add');
            Route::match(['get','post'],'{id}/ubah', 'ubahAkun')->name('edit');
            Route::delete('{id}/hapus', 'hapusAkun')->name('delete');
        });

        // Route::controller(MakananController::class)
        // ->prefix('makanan')
        // ->as('makanan.')
        // ->group(function () {
        //     Route::get('/', 'index')->name('index');
        //     Route::post('showdataMakanan', 'showMakanan')->name('showMakanan');
        //     Route::match(['get','post'],'tambah', 'tambahMakanan')->name('add');
        //     Route::match(['get','post'],'{id}/ubah', 'ubahMakanan')->name('edit');
        //     Route::delete('{id}/hapus', 'hapusMakanan')->name('delete');
        //     Route::get('export_excel', 'export_excel')->name('export.excel');
        // });
        
        Route::prefix('makanan')->name('makanan.')->group(function () {
            Route::get('/', [MakananController::class, 'index'])->name('index');
            Route::post('showdataMakanan', [MakananController::class, 'showMakanan'])->name('showMakanan');
            Route::match(['get', 'post'], 'tambah', [MakananController::class, 'tambahMakanan'])->name('add');
            Route::match(['get', 'post'], '{id}/ubah', [MakananController::class, 'ubahMakanan'])->name('edit');
            Route::delete('{id}/hapus', [MakananController::class, 'hapusMakanan'])->name('delete');
            Route::get('export_excel', [MakananController::class, 'export_excel'])->name('export.excel');
        });



});


