<?php

namespace App\Traits;

use Cloudipsp\Checkout;
use Cloudipsp\Configuration;
use Cloudipsp\Exception\ApiException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session; // Добавлен импорт Session

trait FondyTrait
{
    /**
     * @param int $amount
     * @param string $email
     * @return JsonResponse
     * @throws ApiException
     */
    public static function fondyBuy(int $amount = 0, $merchant_data = [], string $email = '', $response_url = '', $callback_url = ''): JsonResponse
    {
        $amount *= 100;

        if ($amount <= 0) {
            return response()->json(['paymentUrl' => route('errors.500')]);
        }

        Configuration::setMerchantId(config('services.cloudipsp.merchant_id'));
        Configuration::setSecretKey(config('services.cloudipsp.secret_key'));

        $data = [
            'order_desc' => 'Тестовый заказ SDK',
            'currency' => 'UAH',
            'amount' => $amount,
            'response_url' => $response_url,
            'server_callback_url' => $callback_url,
            'sender_email' => $email,
            'lang' => 'ua',
            'product_id' => 'some_product_id',
            'lifetime' => 36000,
            'merchant_data' => $merchant_data
        ];
        $paymentUrl = Checkout::url($data)->getData();

        return response()->json(['paymentUrl' => $paymentUrl]);
    }
}
