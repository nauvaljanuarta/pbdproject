<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
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


//satuan
Route::get('admin/satuan', [SatuanController::class, 'index']);
Route::post('admin/satuan/add', [SatuanController::class, 'store'])->name('add.satuan');
Route::put('admin/satuan/{id}', [SatuanController::class, 'update'])->name('update.satuan');
Route::delete('admin/satuan/{id}', [SatuanController::class, 'destroy'])->name('destroy.satuan');

Route::get('admin/barang', [BarangController::class, 'index']);

Route::get('/', [UserController::class, 'index']);
