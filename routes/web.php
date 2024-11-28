<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\VendorController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/admin/role', function () {
    return view('admin.role');
});
Route::get('/admin/user', function () {
    return view('admin.user');
});

Route::get('/coba', function () {
    return view('coba');
});

//auth
Route::get('/', [AuthController::class, 'loginview']);
Route::get('/register', [AuthController::class, 'registerview']);

//dashboard
Route::get('/dashboard',[UserController::class, 'index']);

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

//role
Route::get('admin/role', [RoleController::class, 'index']);
Route::post('admin/role/add', [RoleController::class, 'store'])->name('add.role');
Route::put('admin/role/{id}', [RoleController::class, 'update'])->name('update.role');
Route::delete('admin/role/{id}', [RoleController::class, 'destroy'])->name('destroy.role');

//role
Route::get('admin/role', [RoleController::class, 'index']);
Route::post('admin/role/add', [RoleController::class, 'store'])->name('add.role');
Route::put('admin/role/{id}', [RoleController::class, 'update'])->name('update.role');
Route::delete('admin/role/{id}', [RoleController::class, 'destroy'])->name('destroy.role');
