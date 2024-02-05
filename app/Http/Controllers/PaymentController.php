<?php

namespace App\Http\Controllers;

use App\Traits\FondyTrait;
use Carbon\Carbon;
use Cloudipsp\Checkout;
use Cloudipsp\Exception\ApiException;
use Cloudipsp\P2pcredit;
use Illuminate\Http\Request;
use Cloudipsp\Configuration;

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
        $merchant_data = json_decode($request->input('merchant_data'), false, 512, JSON_THROW_ON_ERROR);
        $order_time = $request->input('order_time');
        \DB::table($merchant_data->type)
            ->where('id', $merchant_data->id)
            ->update(['end_subscription' => Carbon::parse($order_time)]);
        dd($merchant_data);
//        order_time
//        actual_amount == 100
//        response_status == 'success'
//        order_id
//        payment_id
//        product_id
    }
    public function callback_url(Request $request){
//        $model  = new \App\Models\Qualification();
//        $model->name =  json_encode($request->input() ?? '');
//        $model->save();

        \Log::info( json_encode($request->input() ?? ''));
        \Log::info( $request->input());

    }
}
