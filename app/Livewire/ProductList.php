<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\Product;
use App\Services\MercadoPagoService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ProductList extends Component
{

    public $products;

    public function mount(): void
    {
        $this->products = Product::all();
    }

    public function buy($productId): \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
    {

        $product = Product::find($productId);

        $service = new MercadoPagoService();

        $order = Order::create([
            'user_id'    => auth()->id(),
            'product_id' => $product->id,
            'total_amount'      => $product->price,
            'status'     => 'pending',
        ]);

        $checkoutUrl = $service->createCheckoutUrl([
            'name' => $product->name,
            'quantity' => 1,
            'price' => $product->price,
            "order_id" => (string)$order->id,
        ]);

        return redirect($checkoutUrl->init_point);

    }

    public function render(): Factory|View
    {

        return view('livewire.product-list');
    }
}
