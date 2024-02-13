<?php

namespace App\Http\Controllers;

use App\Models\Category\Operations\TransactionCategory;
use App\Traits\FondyTrait;
use Carbon\Carbon;
use Cloudipsp\Checkout;
use Cloudipsp\Exception\ApiException;
use Cloudipsp\P2pcredit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Cloudipsp\Configuration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    use FondyTrait;

    public function form()
    {
        return view('payment.form');
    }

    /**
     * @throws ApiException
     */
    public function initiatePayment(Request $request): \Illuminate\Http\JsonResponse
    {
        return self::fondyBuy(1, 'eliphas.sn@gmail.com');
    }

    public function response_url(Request $request): \Illuminate\Http\RedirectResponse
    {
        $now = Carbon::now();
        $merchant_data = json_decode($request->input('merchant_data'), false, 512, JSON_THROW_ON_ERROR);

        $order_time = $request->input('order_time');
        $transaction = TransactionCategory::where('key', $merchant_data->key)->first();
        $transaction->update(['status' => 2, 'get_transaction_at'=> $now]);




        $merchant_data = json_decode($request->input('merchant_data'), false, 512, JSON_THROW_ON_ERROR);
        return redirect()->route('page.class', [
            'class_name' => $merchant_data->type,
            'id' => $merchant_data->id
        ]);
    }

    public function callback_url(Request $request): void
    {

//        $now = Carbon::now();
//        $merchant_data = json_decode($request->input('merchant_data'), false, 512, JSON_THROW_ON_ERROR);
//
//        $order_time = $request->input('order_time');
//        $transaction = TransactionCategory::where('key', $merchant_data->key)->first();
//        $transaction->update(['status' => 2, 'get_transaction_at'=> $now]);
//
//        Log::info(json_encode([
//            'type' => 'transaction',
//            [
//                'payment' => 'fondy',
//                'product_id' => $request->input('product_id'),
//                'payment_id' => $request->input('payment_id'),
//                'merchant_key' => $merchant_data->key,
//                'order_id' => $request->input('order_id'),
//                'actual_amount' => $request->input('actual_amount'),
//                'response_status' => $request->input('response_status'),
//                'order_time' => $request->input('order_time'),
//                'time' => $now,
//            ]
//        ], JSON_THROW_ON_ERROR));
    }
}
