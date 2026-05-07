<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Category List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <p class="text-gray-600 dark:text-gray-400">Manage your category</p>
                    <a href="{{ route('category.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                        + Add Category
                    </a>
                </div>

                <table class="w-full text-left border-collapse text-gray-800 dark:text-gray-200">
                    <thead>
                        <tr class="border-b border-gray-700">
                            <th class="px-6 py-3 text-sm font-bold uppercase">Name</th>
                            <th class="px-6 py-3 text-sm font-bold uppercase">Total Product</th>
                            <th class="px-6 py-3 text-sm font-bold uppercase text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                        <tr class="border-b border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            <td class="px-6 py-4">{{ $category->name }}</td>
                            <td class="px-6 py-4">{{ $category->products_count }}</td>
                            <td class="px-6 py-4 text-center">
                                <form action="{{ route('category.destroy', $category) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 font-bold">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-gray-500">No categories found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>