<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Pastikan ini 'categories' agar sama dengan migration kamu (plural)
    protected $table = 'categories';

    protected $fillable = ['name'];

    public function products()
    {
        // Relasi satu kategori ke banyak produk
        return $this->hasMany(Product::class, 'category_id');
    }
}