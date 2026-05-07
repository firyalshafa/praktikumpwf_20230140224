<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

// Halaman Publik
Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', [AboutController::class, 'index'])->name('about');

// Halaman Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// GRUP 1: User Login (Umum)
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Product (Akses kontrol create/edit ada di Controller)
    Route::resource('products', ProductController::class);
});

// GRUP 2: Khusus Admin (Category)
Route::middleware(['auth', 'can:manage-category'])->group(function () {
    Route::resource('category', CategoryController::class);
});

require __DIR__.'/auth.php';