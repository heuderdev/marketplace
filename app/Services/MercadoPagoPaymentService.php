<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Exceptions\MPApiException;

class MercadoPagoPaymentService
{
    public function getPaymentInfoByWebhookId(string $paymentId): ?array
    {
        MercadoPagoConfig::setAccessToken(config('app.MP_ACCESS_TOKEN'));

        try {
            $client = new PaymentClient();
            $payment = $client->get($paymentId);

            if ($payment) {
                return [
                    'status' => $payment->status,
                    'external_reference' => $payment->external_reference,
                    'amount' => $payment->transaction_amount,
                    'details' => $payment
                ];
            }
        } catch (MPApiException $e) {
            Log::error('Erro na consulta MP Payment', [
                'code' => $e->getApiResponse()->getStatusCode(),
                'body' => $e->getApiResponse()->getContent()
            ]);
        } catch (\Throwable $e) {
            Log::error('Erro inesperado no service Mercado Pago', [
                'msg' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
        return null;
    }
}
