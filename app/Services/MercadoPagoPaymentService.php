<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Exceptions\MPApiException;
use MercadoPago\Resources\Payment;

class MercadoPagoPaymentService
{
    /**
     * Busca informações de pagamento por ID recebido via webhook.
     *
     * @param string $paymentId
     * @return array{
     *      status: string,
     *      external_reference: ?string,
     *      amount: float,
     *      details: Payment
     * }|null
     */
    public function getPaymentInfoByWebhookId(string $paymentId): ?array
    {
        // A configuração do token pode estar no construtor se usada em vários métodos.
        $this->configure();

        try {
            $client = new PaymentClient();
            /** @var Payment $payment */
            $payment = $client->get($paymentId);

            if ($payment) {
                return [
                    'status' => $payment->status,
                    'external_reference' => $payment->external_reference ?? null,
                    'amount' => (float) $payment->transaction_amount,
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
                // Trace em produção pode ser removido por segurança
                'trace' => app()->environment('local') ? $e->getTraceAsString() : null
            ]);
        }
        return null;
    }

    private function configure(): void
    {
        // Checagem extra para evitar configuração nula
        $token = config('app.MP_ACCESS_TOKEN');
        if (!$token) {
            Log::error('Access token Mercado Pago não configurado.');
            throw new \RuntimeException('Access token Mercado Pago não configurado');
        }
        MercadoPagoConfig::setAccessToken($token);
    }
}
