<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Pastikan return true agar request diizinkan
        return true; 
    }

    public function rules(): array
    {
        return [
            'name'        => 'required|string|max:255',
            'qty'         => 'required|integer|min:1',
            'price'       => 'required|numeric|min:1000',
            
            // TAMBAHKAN BARIS INI:
            // Artinya: category_id wajib diisi dan harus ada di tabel categories kolom id
            'category_id' => 'required|exists:categories,id', 
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'        => 'Nama produk wajib diisi.',
            'name.max'             => 'Nama produk tidak boleh lebih dari 255 karakter.',
            'qty.required'         => 'Jumlah produk wajib diisi.',
            'qty.integer'          => 'Jumlah produk harus berupa angka bulat.',
            'qty.min'              => 'Jumlah produk minimal 1.',
            'price.required'       => 'Harga produk wajib diisi.',
            'price.numeric'        => 'Harga produk harus berupa angka yang valid.',
            'price.min'            => 'Harga produk minimal Rp 1.000.',
            
            // PESAN ERROR UNTUK KATEGORI:
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists'   => 'Kategori yang dipilih tidak valid.',
        ];
    }
}