<?php

namespace App\Http\Controllers;

use Cloudipsp\Checkout;
use Cloudipsp\Exception\ApiException;
use Cloudipsp\P2pcredit;
use Illuminate\Http\Request;
use Cloudipsp\Configuration;

class PaymentController extends Controller
{
    public function form(){
        return view('payment.form');
    }
    /**
     * @throws ApiException
     */
    public function initiatePayment(Request $request)
    {
        $email = $request->input('email') ?? 'test@fondy.eu';
        $amount = ($request->input('amount') * 100) ?? 0;
        if ($amount <= 0) {
            return response()->json(['paymentUrl' => route('errors.500')]);
        }

        Configuration::setMerchantId(config('services.cloudipsp.merchant_id'));
        Configuration::setSecretKey(config('services.cloudipsp.secret_key'));
        $data = [
            'order_desc' => 'Тестовый заказ SDK',
            'currency' => 'UAH',
            'amount' => $amount,
            'response_url' => route('payment.fondy.response-url'),
            'server_callback_url' => route('payment.fondy.callback-url'),
            'sender_email' => $email,
            'lang' => 'ru',
            'product_id' => 'some_product_id',
            'lifetime' => 36000,
            'merchant_data' => [
                'custom_data1' => 'Some string',
                'custom_data2' => '00000000000',
                'custom_data3' => '3!@#$%^&(()_+?"}'
            ]
        ];
        $paymentUrl = Checkout::url($data)->getData();

        return response()->json(['paymentUrl' => $paymentUrl]);
    }

    public function responseurl(Request $request)
    {
        dd($request->input());
    }
}
