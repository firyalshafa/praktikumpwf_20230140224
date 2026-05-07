<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Produk: {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 p-6 shadow-sm sm:rounded-lg">
                
                <form action="{{ route('products.update', $product->id) }}" method="POST">
                    @csrf
                    @method('PUT') {{-- WAJIB ADA UNTUK UPDATE --}}

                    {{-- Nama Produk --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300">Nama Produk</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" 
                               class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-white">
                    </div>

                    {{-- Kategori (TAMBAHKAN INI) --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300">Kategori</label>
                        <select name="category_id" class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-white">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Jumlah (Qty) --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300">Jumlah (Qty)</label>
                        <input type="number" name="qty" value="{{ old('qty', $product->qty) }}" 
                               class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-white">
                    </div>

                    {{-- Harga --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300">Harga (Rp)</label>
                        <input type="number" name="price" value="{{ old('price', $product->price) }}" 
                               class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-white">
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('products.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update Produk</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>