<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Product List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 dark:text-white">Product Inventory</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Manage or view all available products.</p>
                    </div>
                    
                    @can('manage-product')
                        <a href="{{ route('products.create') }}" class="inline-flex items-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg transition ease-in-out duration-150">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Add Product
                        </a>
                    @endcan
                </div>

                @if (session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow-sm" role="alert">
                        <p class="font-bold">Success!</p>
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th class="px-6 py-3">#</th>
                                <th class="px-6 py-3">Name</th>
                                <th class="px-6 py-3">Category</th>
                                <th class="px-6 py-3">Qty</th> {{-- TAMBAHAN HEADER QTY --}}
                                <th class="px-6 py-3">Price</th>
                                <th class="px-6 py-3 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition">
                                    <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                        {{ $product->name }}
                                    </td>
                                    
                                    <td class="px-6 py-4">
                                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-200">
                                            {{ $product->category->name ?? 'No Category' }}
                                        </span>
                                    </td>

                                    {{-- TAMBAHAN KOLOM JUMLAH (QTY) --}}
                                    <td class="px-6 py-4 font-bold text-gray-700 dark:text-gray-300">
                                        {{ $product->qty }}
                                    </td>

                                    <td class="px-6 py-4 font-mono text-indigo-600 dark:text-indigo-400">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </td>
                                    
                                    <td class="px-6 py-4">
                                        <div class="flex justify-center items-center space-x-4">
                                            <a href="{{ route('products.show', $product) }}" class="text-blue-500 hover:text-blue-700 transition" title="View Detail">
                                                <span class="text-xl">👁️</span>
                                            </a>

                                            @can('update', $product)
                                                <a href="{{ route('products.edit', $product) }}" class="text-yellow-500 hover:text-yellow-600 transition" title="Edit Product">
                                                    <span class="text-xl">✏️</span>
                                                </a>
                                            @endcan

                                            @can('delete', $product)
                                                <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-600 transition" title="Delete Product">
                                                        <span class="text-xl">🗑️</span>
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400 italic">
                                        No products found in the inventory.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>