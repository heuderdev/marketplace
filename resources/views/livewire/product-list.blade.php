<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mt-6 px-8 md:px-80">
    @foreach($products as $product)
        <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow p-6 flex flex-col items-center text-center">
            <div class="w-24 h-24 mb-4 bg-gradient-to-tr from-blue-100 to-blue-300 rounded-full flex items-center justify-center text-3xl font-bold text-blue-700">
                {{ mb_substr($product->name, 0, 1) }}
            </div>
            <h2 class="text-lg font-semibold text-gray-800 mb-2">{{ $product->name }}</h2>
            <p class="text-gray-500 text-sm mb-4">{{ $product->description }}</p>
            <span class="text-xl font-bold text-blue-600 mb-2">
                R$ {{ number_format($product->price, 2, ',', '.') }}
            </span>
            <button wire:click="buy({{ $product->id }})" class="mt-auto bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition">
                Comprar
            </button>
        </div>
    @endforeach
</div>
