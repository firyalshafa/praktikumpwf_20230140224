<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    // GET: Menampilkan semua produk
    public function index()
    {
        $products = Product::with('category')->get();
        return response()->json([
            'message' => 'Daftar produk berhasil diambil',
            'data' => $products
        ], 200);
    }

    // POST: Menyimpan produk baru
    public function store(StoreProductRequest $request)
    {
        try {
            $validated = $request->validated();
            $validated['user_id'] = Auth::id(); // Mengambil ID dari token

            $product = Product::create($validated);

            Log::info('API: Menambah data produk', ['data' => $product]);

            return response()->json([
                'message' => 'Produk berhasil ditambahkan!!',
                'data' => $product,
            ], 201);

        } catch (\Throwable $e) {
            Log::error('Error API Store Product: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal menambah produk'], 500);
        }
    }

    // GET {id}: Menampilkan detail satu produk
    public function show(int $id)
    {
        $product = Product::with('category')->find($id);

        if (!$product) {
            return response()->json(['message' => 'Product tidak ditemukan'], 404);
        }

        return response()->json([
            'message' => 'Product retrieved successfully',
            'data' => $product
        ], 200);
    }

    // PUT {id}: Update data produk
    public function update(Request $request, int $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product tidak ditemukan'], 404);
        }

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'qty'         => 'required|integer|min:1',
            'price'       => 'required|numeric|min:1000',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product->update($validated);

        return response()->json([
            'message' => 'Produk berhasil diperbarui',
            'data' => $product
        ], 200);
    }

    // DELETE {id}: Menghapus produk
    public function destroy(int $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product tidak ditemukan'], 404);
        }

        $product->delete();

        return response()->json([
            'message' => 'Produk berhasil dihapus'
        ], 200);
    }
}