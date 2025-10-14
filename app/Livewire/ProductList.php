<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\Product;
use App\Services\MercadoPagoService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Log;
use JsonException;
use Livewire\Component;
use Illuminate\Support\Collection;

class ProductList extends Component
{
    /**
     * @var Collection<int, Product>
     */
    public Collection $products;

    public function mount(): void
    {
        $this->products = Product::all();
    }

    /**
     * @param int|string $productId
     * @return RedirectResponse|Redirector
     * @throws JsonException
     */
    public function buy(int|string $productId): RedirectResponse|Redirector
    {
        $product = Product::find($productId);
        $service = new MercadoPagoService();

        $order = Order::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'total_amount' => $product->price,
            'status' => 'pending',
        ]);

        $checkoutUrl = $service->createCheckoutUrl([
            'name' => $product->name,
            'quantity' => 1,
            'price' => $product->price,
            "order_id" => (string)$order->id,
        ]);

        Log::debug(json_encode($checkoutUrl, JSON_THROW_ON_ERROR));
        return redirect($checkoutUrl->init_point);

    }

    public function render(): Factory|View
    {
        return view('livewire.product-list');
    }
}
