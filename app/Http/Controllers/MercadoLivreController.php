<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Exceptions\MPApiException;

class MercadoLivreController extends Controller
{
    public function weebhook(Request $request): \Illuminate\Http\JsonResponse
    {
        $paymentId = $request->input('data.id');
        if (!$paymentId) {
            Log::error('Webhook Mercado Pago: paymentId não encontrado.', $request->all());
            return response()->json(['error' => 'paymentId ausente'], 400);
        }

        $paymentService = app(\App\Services\MercadoPagoPaymentService::class);
        $info = $paymentService->getPaymentInfoByWebhookId($paymentId);

        if ($info && $info['status'] === 'approved') {
            [$userId, $orderId] = explode('|', $info['external_reference']);
            // ... Atualiza pedido, libera item etc
            Log::info("Pagamento aprovado MP!", [
                'payment_id' => $paymentId,
                'user_id' => $userId,
                'order_id' => $orderId,
                'amount'   => $info['amount'],
                'all'      => $info['details']
            ]);
            return response()->json(['success' => true], 200);
        }

        return response()->json(['result' => $info['status'] ?? 'erro'], 200);
    }

    public function success(Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json($request->all());
    }

    public function failure(Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json($request->all());
    }

    public function pending(Request $request)
    {
        $paymentId = $request->input('payment_id');
        $paymentService = app(\App\Services\MercadoPagoPaymentService::class);
        $info = $paymentService->getPaymentInfoByWebhookId($paymentId);
        if ($info["status"] == "approved") {
            $ticket_url = $info["details"]->point_of_interaction->transaction_data->ticket_url ?? null;
            return redirect($ticket_url);
        } else {
            return response()->json($info);
        }
    }

}
