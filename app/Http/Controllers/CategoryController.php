<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Menampilkan daftar kategori beserta total produknya.
     */
    public function index()
    {
        // Mengambil kategori dan menghitung jumlah produk terkait secara otomatis
        $categories = Category::withCount('products')->get();

        return view('category.index', compact('categories'));
    }

    /**
     * Menampilkan form untuk menambah kategori baru.
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Menyimpan data kategori baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi agar nama kategori wajib diisi dan tidak boleh kembar
        $request->validate([
            'name' => 'required|unique:categories,name|max:255',
        ]);

        Category::create([
            'name' => $request->name,
        ]);

        return redirect()->route('category.index')->with('success', 'Category created successfully!');
    }

    /**
     * Menghapus data kategori.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('category.index')->with('success', 'Category deleted successfully!');
    }
}