<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerMenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TableController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

// Route untuk Guest (Login) dan Pelanggan
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [SessionController::class, 'index'])->name('login');
    Route::post('/login', [SessionController::class, 'store'])->name('login.store');

    Route::get('/menu/{qr_token}', [CustomerMenuController::class, 'showMenuForTable'])->name('customer.menu');

    Route::controller(CartController::class)->prefix('cart')->name('cart.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/add', 'add')->name('add');
        Route::post('/update', 'update')->name('update');
        Route::post('/remove', 'remove')->name('remove');
        Route::get('/count', 'getCartCount')->name('count');
        Route::post('/clear', 'clear')->name('clear');
    });

    Route::get('/api/cart', [CartController::class, 'getCartData'])->name('api.cart.data');

    Route::controller(OrderController::class)->group(function () {
        Route::post('/orders', 'store')->name('orders.store');
        Route::get('/orders/{order}', 'show')->name('orders.show');
        Route::post('/orders/{order}/pay', 'createPayment')->name('orders.pay');
        Route::get('/orders/{order}/status', 'showStatusPage')->name('orders.status');
        Route::get('/orders/{order}/check-status', 'checkStatus')->name('orders.check-status');
        Route::get('/customer/success', 'success')->name('customer.success');
        Route::post('/orders/{order}/cancel', 'cancel')->name('orders.cancel'); // << Tambahan
    });
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
        Route::get('/{table}/table-edit', 'edit')->name('tables.edit');
        Route::put('/{table}/table-edit', 'update')->name('tables.update');
        Route::delete('/{table}/table-delete', 'destroy')->name('tables.destroy');
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

    Route::controller(AdminOrderController::class)->prefix('admin/orders')->name('admin.orders.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/check-new', 'checkNewOrders')->name('checkNew');

        // [MODIFIKASI] Route untuk mengambil data pesanan aktif
        Route::get('/active', 'getActiveOrders')->name('active');

        // [MODIFIKASI] Route untuk mengambil data riwayat pesanan
        Route::get('/history', 'getOrderHistory')->name('history');

        Route::get('/{order}', 'show')->name('show');
        Route::post('/{order}/update-status', 'updateStatus')->name('updateStatus');
    });

    Route::controller(DashboardController::class)->prefix('admin/dashboard')->name('admin.dashboard.')->group(function () {
        Route::get('/index', 'index')->name('index');
    });
});
