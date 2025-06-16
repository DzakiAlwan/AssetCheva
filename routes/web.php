<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BorrowingController;
use App\Http\Middleware\IsLogin;
use Illuminate\Support\Facades\Route;

Route::match(['get', 'post'], '/', [AuthController::class, 'handleLogin'])->name('login');
Route::get('/register', [AuthController::class, 'registerView']);
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout']);



Route::middleware(IsLogin::class)->group(function () {

    // Rute Produk (Barang)(ADMIN DAN DOSEN)
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/create', [ProductController::class, 'create']);
    Route::get('/products/detail/{id}', [ProductController::class, 'show']);
    Route::post('/products/store', [ProductController::class, 'store']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'delete']);
    Route::get('/addUser', [DashboardController::class, 'addUser'])->name('users.add');
    Route::get('/users/create', [DashboardController::class, 'create'])->name('users.create');
    Route::post('/users', [DashboardController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [DashboardController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [DashboardController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [DashboardController::class, 'destroy'])->name('users.destroy');

    // Rute Kategori Produk (Barang)(ADMIN DAN DOSEN)
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/create', [CategoryController::class, 'create']);
    Route::get('/categories/edit/{id}', [CategoryController::class, 'edit']);
    Route::post('/categories/store', [CategoryController::class, 'store']);
    Route::put('/categories/{id}', [CategoryController::class, 'update']);
    Route::delete('/categories/{id}', [CategoryController::class, 'delete']);

    // Rute User
    Route::get('/dashboard-users', [UserController::class, 'userView'])->name('users.index');
    Route::get('/search', [UserController::class, 'search'])->name('products.search');

    // Rute Peminjaman Barang(ADMIN DAN DOSEN)
    Route::middleware(IsLogin::class)->group(function () {
        Route::get('/borrowings', [BorrowingController::class, 'index'])->name('borrowings.index'); // Daftar peminjaman
        Route::get('/borrowings/create', [BorrowingController::class, 'create'])->name('borrowings.create'); // Form tambah peminjaman
        Route::post('/borrowings/store', [BorrowingController::class, 'store'])->name ('borrowings.store'); // Simpan peminjaman
        Route::get('/borrowings/{borrowing}/edit', [BorrowingController::class, 'edit'])->name('borrowings.edit');
        Route::put('/borrowings/{borrowing}', [BorrowingController::class, 'update'])->name('borrowings.update');
        Route::delete('/borrowings/{id}', [BorrowingController::class, 'destroy']); // Hapus peminjaman
    });

});
