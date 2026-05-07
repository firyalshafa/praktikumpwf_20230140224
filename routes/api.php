<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController; // <--- WAJIB TAMBAH INI

// Route Login untuk dapat token (Bisa diakses siapa saja)
Route::post('/login', [AuthController::class, 'getToken']);

// Route yang butuh Login (Terproteksi token Sanctum)
Route::middleware('auth:sanctum')->group(function () {
    
    /**
     * API Resource Product 
     * Otomatis mencakup index, store, show, update, destroy
     * (Menghapus rute manual yang tadi ganda)
     */
    Route::apiResource('product', ProductController::class);

    /**
     * API Resource Category
     * Mencakup semua fungsi CRUD untuk kategori
     */
    Route::apiResource('category', CategoryController::class);
    
});