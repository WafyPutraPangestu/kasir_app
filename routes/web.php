<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerMenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TableController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

// Route untuk Guest (Login) dan Pelanggan
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [SessionController::class, 'index'])->name('login');
    Route::post('/login', [SessionController::class, 'store'])->name('login.store');

    Route::get('/menu/{qr_token}', [CustomerMenuController::class, 'showMenuForTable'])->name('customer.menu');
});


// Route untuk Admin
Route::middleware(['admin', 'auth'])->group(function () {
    Route::post('/logout', [SessionController::class, 'destroy'])->name('logout');

    // == INI CONTROLLER TABLE (SESUAI KODE ANDA) ==
    Route::controller(TableController::class)->prefix('admin')->name('admin.')->group(function () {
        // Nama-nama method ini (tableindex, tablecreate) harus sesuai dengan yang ada di TableController Anda
        Route::get('/table-index', 'tableindex')->name('tables.index');
        Route::get('/create-table', 'tablecreate')->name('tables.create');
        Route::post('/create-table', 'tablestore')->name('tables.store');
    });

    // == INI CONTROLLER PRODUK (SUDAH DILENGKAPI SECARA MANUAL) ==
    Route::controller(ProdukController::class)->prefix('admin/produk')->name('admin.produk.')->group(function () {
        Route::get('/', 'index')->name('index'); // TAMPILKAN DAFTAR PRODUK
        Route::get('/create', 'create')->name('create'); // TAMPILKAN FORM TAMBAH
        Route::post('/', 'store')->name('store'); // SIMPAN PRODUK BARU
        Route::get('/{product}/edit', 'edit')->name('edit'); // TAMPILKAN FORM EDIT
        Route::put('/{product}', 'update')->name('update'); // UPDATE PRODUK
        Route::delete('/{product}', 'destroy')->name('destroy'); // HAPUS PRODUK
    });

    // == INI CONTROLLER CATEGORY (SESUAI KODE ANDA) ==
    Route::controller(CategoryController::class)->prefix('admin/category')->name('admin.category.')->group(function () {
        // URL menjadi: GET admin/category
        Route::get('/', 'index')->name('index');

        // URL menjadi: GET admin/category/create
        Route::get('/create', 'create')->name('create');

        // URL menjadi: POST admin/category
        Route::post('/', 'store')->name('store');

        // URL menjadi: GET admin/category/{category}/edit
        Route::get('/{category}/edit', 'edit')->name('edit');

        // URL menjadi: PUT admin/category/{category}
        Route::put('/{category}', 'update')->name('update'); // Menggunakan PUT adalah standar untuk update

        // URL menjadi: DELETE admin/category/{category}
        Route::delete('/{category}', 'destroy')->name('destroy');
    });

    // == INI CONTROLLER ORDER (SESUAI KODE ANDA) ==
    Route::controller(OrderController::class)->group(function () {
        Route::get('/orders/{order}', 'show')->name('orders.show');
        Route::post('/orders/{order}/pay', 'createPayment')->name('orders.pay');
        Route::post('/midtrans/callback', 'handleCallback')->name('midtrans.callback');
    });
});
