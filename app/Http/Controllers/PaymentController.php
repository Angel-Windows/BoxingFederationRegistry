<?php

namespace App\Http\Controllers;

use App\Models\Category\Operations\TransactionCategory;
use App\Traits\FondyTrait;
use Carbon\Carbon;
use Cloudipsp\Exception\ApiException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

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

    public function response_url(Request $request)
    {
        $now = Carbon::now();
        $merchant_data = json_decode($request->input('merchant_data'));
        $register_ids = Session::get('register_ids');
        $merchant_type = $merchant_data->type ?? '';
        $merchant_id = $merchant_data->id ?? null;
        if ( Session::has('register_ids')){
            if (!empty($merchant_type) && isset($register_ids[$merchant_type])) {
                $register_ids[$merchant_type][] = $merchant_id;
            } else {
                $register_ids[$merchant_type] = [$merchant_id];
            }
        }else{
            $register_ids[$merchant_type] = [$merchant_id];
        }

        Log::channel('transactions')->info(json_encode([
            'type' => 'transaction response',
            [
                'payment' => 'fondy',
                'product_id' => $request->input('product_id'),
                'payment_id' => $request->input('payment_id'),
                'merchant_key' => $merchant_data->key,
                'order_id' => $request->input('order_id'),
                'actual_amount' => $request->input('actual_amount'),
                'response_status' => $request->input('response_status'),
                'order_time' => $request->input('order_time'),
                'callback_time' => $now,
            ]
        ], JSON_THROW_ON_ERROR));
        Session::put('register_ids', $register_ids);


        return redirect()->route('page.class', [
            'class_name' => $merchant_data->type,
            'id' => $merchant_data->id
        ]);
    }

    public function callback_url(Request $request): void
    {
        $now = Carbon::now();
        $merchant_data = json_decode($request->input('merchant_data'), false, 512, JSON_THROW_ON_ERROR);

        $order_time = $request->input('order_time');
        $transaction = TransactionCategory::where('key', $merchant_data->key)->first();
        $transaction->update(['status' => 2, 'get_transaction_at' => $now]);

        Log::channel('transactions')->info(json_encode([
            'type' => 'transaction',
            [
                'payment' => 'fondy',
                'product_id' => $request->input('product_id'),
                'payment_id' => $request->input('payment_id'),
                'merchant_key' => $merchant_data->key,
                'order_id' => $request->input('order_id'),
                'actual_amount' => $request->input('actual_amount'),
                'response_status' => $request->input('response_status'),
                'order_time' => $order_time,
                'callback_time' => $now,
            ]
        ], JSON_THROW_ON_ERROR));
    }
}
