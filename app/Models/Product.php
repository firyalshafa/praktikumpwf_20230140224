<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * * Pastikan kolom-kolom ini sesuai dengan nama kolom di phpMyAdmin kamu.
     * Tadi di phpMyAdmin kolomnya adalah 'qty' (bukan quantity), jadi ini sudah benar.
     */
    protected $fillable = [
        'name',
        'qty',
        'price',
        'user_id',
        'category_id',
    ];

    /**
     * Relasi ke model Category.
     * Menghubungkan category_id di tabel products ke id di tabel categories.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Relasi ke model User.
     * Menghubungkan user_id di tabel products ke id di tabel users.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}