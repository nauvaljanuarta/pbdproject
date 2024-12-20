<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\MarginController;
use App\Http\Controllers\PengadaanController;
use App\Http\Controllers\PenerimaanController;
use App\Http\Controllers\ReturController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\PenjualanController;

// Route::get('/', function () {
//     return view('auth.login');
// });

// Route::get('/admin/role', function () {
//     return view('admin.role');
// });


// Route::get('/coba', function () {
//     return view('pengadaan.detail');
// });

// Auth routes
Route::get('/', [AuthController::class, 'loginview'])->name('loginpage');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'registerview']);
Route::post('/register', [AuthController::class, 'register'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');
    //role
    Route::get('admin/role', [RoleController::class, 'index']);
    Route::post('admin/role/add', [RoleController::class, 'store'])->name('add.role');
    Route::put('admin/role/{id}', [RoleController::class, 'update'])->name('update.role');
    Route::delete('admin/role/{id}', [RoleController::class, 'destroy'])->name('destroy.role');

    //user
    Route::get('admin/user', [UserController::class, 'detail']);
    Route::post('admin/user/add', [UserController::class, 'store'])->name('add.user');
    Route::put('admin/user/{id}', [UserController::class, 'update'])->name('update.user');
    Route::delete('admin/user/{id}', [UserController::class, 'destroy'])->name('destroy.user');

    //satuan
    Route::get('admin/satuan', [SatuanController::class, 'index']);
    Route::post('admin/satuan/add', [SatuanController::class, 'store'])->name('add.satuan');
    Route::put('admin/satuan/{id}', [SatuanController::class, 'update'])->name('update.satuan');
    Route::delete('admin/satuan/{id}', [SatuanController::class, 'destroy'])->name('destroy.satuan');

    //barang
    Route::get('admin/barang', [BarangController::class, 'index']);
    Route::post('admin/barang/add', [BarangController::class, 'store'])->name('add.barang');
    Route::put('admin/barang/{id}', [BarangController::class, 'update'])->name('update.barang');
    Route::delete('admin/barang/{id}', [BarangController::class, 'destroy'])->name('destroy.barang');

    //vendor
    Route::get('admin/vendor', [VendorController::class, 'index']);
    Route::post('admin/vendor/add', [VendorController::class, 'store'])->name('add.vendor');
    Route::put('admin/vendor/{id}', [VendorController::class, 'update'])->name('update.vendor');
    Route::delete('admin/vendor/{id}', [VendorController::class, 'destroy'])->name('destroy.vendor');

    // marginpenjualan
    Route::get('admin/margin', [MarginController::class, 'index']);
    Route::post('admin/margin/add', [MarginController::class, 'store'])->name('add.margin');
    Route::put('admin/margin/{id}', [MarginController::class, 'update'])->name('update.margin');
    Route::delete('admin/margin/{id}', [MarginController::class, 'destroy'])->name('destroy.margin');

    //pengadaan
    Route::get('admin/pengadaan', [PengadaanController::class, 'index']);
    Route::get('admin/pengadaan/create', [PengadaanController::class, 'create'])->name('create.pengadaan');
    Route::post('admin/pengadaan/add', [PengadaanController::class, 'store'])->name('add.pengadaan');
    Route::get('admin/pengadaan/detail/{id}', [PengadaanController::class, 'show'])->name('detail.pengadaan');
    Route::get('admin/pengadaan/{id}/edit', [PengadaanController::class, 'edit'])->name('pengadaan.edit');
    Route::put('admin/pengadaan/{id}/update', [PengadaanController::class, 'update'])->name('pengadaan.update');
    Route::delete('admin/pengadaan/{id}', [PengadaanController::class, 'destroy'])->name('destroy.pengadaan');

    // penerimaan
    Route::get('admin/penerimaan', [PenerimaanController::class, 'index']);
    Route::post('admin/penerimaan/{id}', [PenerimaanController::class, 'store'])->name('add.penerimaan');
    Route::get('/penerimaan/detail/{idpenerimaan}', [PenerimaanController::class, 'show'])->name('detail.penerimaan');

    //retur
    Route::get('admin/retur', [ReturController::class, 'index']);
    Route::post('admin/retur/{id}', [ReturController::class, 'store'])->name('add.retur');
    Route::get('retur/detail/{idretur}', [ReturController::class, 'show'])->name('detail.retur');

    //stok
    Route::get('admin/stock', [StockController::class, 'index']);
    Route::post('admin/stock/terima/{id}', [StockController::class, 'penerimaanstock'])->name('terima.stock');
    Route::post('admin/stock/jual/{id}', [StockController::class, 'penjualanstock'])->name('jual.stock');

    // penjualan
    Route::get('admin/penjualan', [PenjualanController::class, 'index']);
    Route::get('admin/penjualan/create', [PenjualanController::class, 'create'])->name('create.penjualan');
    Route::post('admin/penjualan/add', [PenjualanController::class, 'store'])->name('add.penjualan');
    Route::get('admin/penjualan/{idpenjualan}', [PenjualanController::class, 'show'])->name('detail.penjualan');
});
