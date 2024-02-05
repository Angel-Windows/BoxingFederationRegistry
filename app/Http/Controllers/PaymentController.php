<?php

namespace App\Http\Controllers;

use App\Traits\FondyTrait;
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
        dd(json_encode($request));

    }
    public function callback_url(Request $request){
        $model  = new \App\Models\Qualification();
        $model->name =  json_encode($request);
        $model->save();
    }
}
