<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan kolom category_id ke tabel products
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Memastikan category_id merujuk ke tabel 'categories'
            $table->foreignId('category_id')
                  ->nullable()
                  ->after('user_id')
                  ->constrained('categories') 
                  ->cascadeOnDelete();
        });
    }

    /**
     * Rollback (menghapus kolom category_id)
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }
};