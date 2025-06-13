<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BorrowingController;
use App\Http\Middleware\IsLogin;
use Illuminate\Support\Facades\Route;

Route::get('/login',[AuthController::class ,'loginView']);
Route::post('/login',[AuthController::class ,'login']);

Route::get('/register',[AuthController::class ,'registerView']);
Route::post('/register',[AuthController::class ,'register']);

Route::post('/logout',[AuthController::class ,'logout']);

Route::get('/' ,[DashboardController::class ,'index']);

Route::get('/user',[UserController::class ,'userView']);
Route::get('/user/search',[UserController::class ,'search'])->name('products.search');

Route::middleware(IsLogin::class)->group(function() {

    // Rute Produk (Barang)
    Route::get('/products',[ProductController::class ,'index']);
    Route::get('/products/create',[ProductController::class ,'create']);
    Route::get('/products/detail/{id}',[ProductController::class ,'show']);
    Route::post('/products/store',[ProductController::class ,'store']);
    Route::put('/products/{id}',[ProductController::class ,'update']);
    Route::delete('/products/{id}',[ProductController::class ,'delete']);

    // Rute Kategori Produk (Barang)
    Route::get('/categories',[CategoryController::class ,'index']);
    Route::get('/categories/create',[CategoryController::class ,'create']);
    Route::get('/categories/edit/{id}',[CategoryController::class ,'edit']);
    Route::post('/categories/store',[CategoryController::class ,'store']);
    Route::put('/categories/{id}',[CategoryController::class ,'update']);
    Route::delete('/categories/{id}',[CategoryController::class ,'delete']);

    // Rute Peminjaman Barang
    Route::middleware(IsLogin::class)->group(function() {
        Route::get('/borrowings', [BorrowingController::class, 'index']); // Daftar peminjaman
        Route::get('/borrowings/create', [BorrowingController::class, 'create']); // Form tambah peminjaman
        Route::post('/borrowings/store', [BorrowingController::class, 'store']); // Simpan peminjaman
        Route::get('/borrowings/edit/{id}', [BorrowingController::class, 'edit']); // Form edit peminjaman
        Route::put('/borrowings/{id}', [BorrowingController::class, 'update']); // Update peminjaman
        Route::delete('/borrowings/{id}', [BorrowingController::class, 'destroy']); // Hapus peminjaman
    });

});
