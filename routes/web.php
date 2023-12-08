<?php

use App\Http\Controllers\AkunController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HomeUserController;
use App\Http\Controllers\MakananController;
use App\Http\Controllers\MakananUserController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\PesananUserController;
use App\Http\Controllers\DetailPesananController;




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

Route::group(['prefix' => 'dashboard/admin', 'middleware' => ['auth', 'role:admin']], function () {
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
            Route::match(['get', 'post'], 'tambah', 'tambahAkun')->name('add');
            Route::match(['get', 'post'], '{id}/ubah', 'ubahAkun')->name('edit');
            Route::delete('{id}/hapus', 'hapusAkun')->name('delete');
        });

    Route::prefix('makanan')->name('makanan.')->group(function () {
        Route::get('/', [MakananController::class, 'index'])->name('index');
        Route::post('showdataMakanan', [MakananController::class, 'showMakanan'])->name('showMakanan');
        Route::match(['get', 'post'], 'tambah', [MakananController::class, 'tambahMakanan'])->name('add');
        Route::match(['get', 'post'], '{id}/ubah', [MakananController::class, 'ubahMakanan'])->name('edit');
        Route::delete('{id}/hapus', [MakananController::class, 'hapusMakanan'])->name('delete');
        Route::get('export_excel', [MakananController::class, 'export_excel'])->name('export.excel');
    });

    Route::prefix('pesanan')
        ->as('pesanan.')
        ->group(function () {
            Route::get('/', [PesananController::class, 'index'])->name('index');
            Route::post('showdataPesanan', [PesananController::class, 'showPesanan'])->name('showPesanan');
            Route::match(['get', 'post'], 'tambah', [PesananController::class, 'tambahPesanan'])->name('add');
            Route::match(['get', 'post'], '{id}/ubah', [PesananController::class, 'ubahPesanan'])->name('edit');
            Route::delete('{id}/hapus', [PesananController::class, 'hapusPesanan'])->name('delete');
        });
});


Route::group(['prefix' => 'dashboard/user', 'middleware' => ['auth', 'role:user']], function () {
    Route::get('/', [HomeUserController::class, 'index'])->name('user.home');

    Route::group(['prefix' => 'profile'], function () {
        Route::get('/', [HomeController::class, 'profile'])->name('user.profile');
        Route::post('update', [HomeController::class, 'updateprofile'])->name('user.profile.update');
    });

    Route::controller(AkunController::class)
        ->prefix('akun')
        ->as('user.akun.')
        ->group(function () {
            Route::get('/', 'index')->name('user.index');
            Route::post('showdata', 'dataTable')->name('user.dataTable');
            Route::match(['get', 'post'], 'tambah', 'tambahAkun')->name('user.add');
            Route::match(['get', 'post'], '{id}/ubah', 'ubahAkun')->name('user.edit');
            Route::delete('{id}/hapus', 'hapusAkun')->name('user.delete');
        });

    Route::prefix('makanan')->name('user.makanan.')->group(function () {
        Route::get('/', [MakananUserController::class, 'index'])->name('user.index');
        Route::post('showdataMakanan', [MakananUserController::class, 'showMakanan'])->name('user.showMakanan');
        Route::match(['get', 'post'], 'tambah', [MakananUserController::class, 'tambahMakanan'])->name('user.add');
        Route::match(['get', 'post'], '{id}/ubah', [MakananUserController::class, 'ubahMakanan'])->name('user.edit');
        Route::delete('{id}/hapus', [MakananUserController::class, 'hapusMakanan'])->name('user.delete');
        Route::get('export_excel', [MakananUserController::class, 'export_excel'])->name('user.export.excel');
    });

    Route::prefix('pesanan')
        ->as('user.pesanan.')
        ->group(function () {
            Route::get('/', [PesananUserController::class, 'index'])->name('user.index');
            Route::post('showdataPesanan', [PesananUserController::class, 'showPesanan'])->name('user.showPesanan');
            Route::match(['get', 'post'], 'tambah', [PesananUserController::class, 'tambahPesanan'])->name('user.add');
            Route::match(['get', 'post'], '{id}/ubah', [PesananUserController::class, 'ubahPesanan'])->name('user.edit');
            Route::delete('{id}/hapus', [PesananUserController::class, 'hapusPesanan'])->name('user.delete');
            Route::get('get-makanan-list', [PesananUserController::class, 'getMakananList'])->name('user.getMakananList');
        });

    Route::prefix('detail-pesanan')->name('user.detail-pesanan.')->group(function () {
        Route::get('/', [DetailPesananController::class, 'index'])->name('user.index');
        Route::post('showdataDetailPesanan', [DetailPesananController::class, 'showDetailPesanan'])->name('user.showDetailPesanan');
        // Tambahkan rute tambah, ubah, dan hapus jika diperlukan
    });
});
