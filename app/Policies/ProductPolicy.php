<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Menentukan apakah user boleh melihat DAFTAR produk.
     */
    public function viewAny(User $user): bool
    {
        // Semua user yang sudah login boleh melihat list produk
        return true;
    }

    /**
     * Menentukan apakah user boleh melihat DETAIL satu produk.
     */
    public function view(User $user, Product $product): bool
    {
        // Semua user yang login boleh melihat detail
        return true;
    }

    /**
     * Menentukan apakah user boleh MENAMBAH produk.
     */
    public function create(User $user): bool
    {
        // Hanya user dengan role admin yang boleh tambah
        return $user->role === 'admin';
    }

    /**
     * Menentukan apakah user boleh MENGUBAH produk.
     */
    public function update(User $user, Product $product): bool
    {
        // Admin boleh mengubah produk apa saja
        return $user->role === 'admin';
    }

    /**
     * Menentukan apakah user boleh MENGHAPUS produk.
     */
    public function delete(User $user, Product $product): bool
    {
        // Admin boleh menghapus produk apa saja
        return $user->role === 'admin';
    }
}