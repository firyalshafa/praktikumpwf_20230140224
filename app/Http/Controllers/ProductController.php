<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $products = Product::with('category')->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        if (Gate::denies('manage-product')) {
            abort(403, 'Hanya Admin yang boleh menambah produk.');
        }

        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(StoreProductRequest $request)
    {
        if (Gate::denies('manage-product')) {
            abort(403);
        }

        $validated = $request->validated();
        $validated['user_id'] = auth()->id();

        try {
            // Pastikan category_id ada di dalam $validated
            Product::create($validated);
            
            return redirect()
                ->route('products.index')
                ->with('success', 'Produk berhasil ditambahkan.');

        } catch (QueryException $e) {
            Log::error('Database error saat simpan produk: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan ke database.');
        } catch (\Throwable $e) {
            Log::error('Error tidak terduga: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem.');
        }
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $this->authorize('update', $product);
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $this->authorize('update', $product);

        // FIX: Simpan hasil validasi ke dalam variabel $validated
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'qty'         => 'required|integer|min:1',
            'price'       => 'required|numeric|min:1000',
            'category_id' => 'required|exists:categories,id',
        ], [
            'name.required'        => 'Nama produk wajib diisi.',
            'qty.min'              => 'Jumlah produk minimal 1.',
            'price.required'       => 'Harga produk wajib diisi.',
            'category_id.required' => 'Kategori wajib dipilih.',
        ]);

        // FIX: Gunakan $validated untuk update agar category_id pasti terbawa
        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diupdate.');
    }

    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}