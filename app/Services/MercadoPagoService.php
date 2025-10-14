<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Exceptions\MPApiException;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Resources\Preference;

class MercadoPagoService
{
    public function __construct()
    {
        MercadoPagoConfig::setAccessToken(config('app.MP_ACCESS_TOKEN'));
    }

    /**
     * Cria preference personalizada para Checkout Pro e retorna o objeto Preference.
     * @param array{name: string, quantity: int, price: float|int, order_id: string} $product
     * @return Preference|null Retorna Preference ou null se erro na API.
     * @throws \Exception
     */
    public function createCheckoutUrl(array $product): ?Preference
    {
        $client = new PreferenceClient();
        $request = [
            "items" => [
                [
                    "title" => $product['name'],
                    "quantity" => $product['quantity'],
                    "unit_price" => (float) $product['price'],
                    "currency_id" => "BRL"
                ]
            ],
            'external_reference' => auth()->id() . "|" . $product['order_id'],
            "payment_methods" => [],
            "back_urls" => [
                "success" => config('app.url') . "/pagamento/success",
                "failure" => config('app.url') . "/pagamento/failure",
                "pending" => config('app.url') . "/pagamento/pending"
            ],
            "auto_return" => "approved",
        ];

        try {
            return $client->create($request);
        } catch (MPApiException $e) {
            Log::error('MercadoPago Preference Error', [
                'code' => $e->getApiResponse()->getStatusCode(),
                'body' => $e->getApiResponse()->getContent()
            ]);
            return null;
        }
    }
}
