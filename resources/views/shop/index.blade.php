<x-guest-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-4xl font-bold text-center mb-8">Our Shop</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse ($products as $product)
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                    <div class="h-48 bg-gray-200 flex items-center justify-center">
                        <span class="text-gray-500">Image</span>
                    </div>
                    <div class="p-4">
                        <h3 class="text-lg font-semibold">{{ $product->name }}</h3>
                        <p class="text-sm text-gray-600 mb-2">{{ $product->category->name ?? 'Uncategorized' }}</p>
                        <p class="text-xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</p>
                        <p class="text-sm text-gray-500">Stock: {{ $product->stock }}</p>

                        <form action="{{ route('cart.store') }}" method="POST" class="mt-4">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <x-primary-button type="submit" class="w-full justify-center">
                                    Add to Cart
                                </x-primary-button>
                        </form>     
                    </div>
                </div>
            @empty
                <p class="col-span-full text-center text-gray-500">No products found.</p>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $products->links() }}
        </div>
    </div>
</x-guest-layout>
