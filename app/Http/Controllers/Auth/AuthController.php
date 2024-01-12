<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\SmsService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * @throws Exception
     */
    public function login(Request $request): JsonResponse
    {
        $phoneNumber = $request->input('phone') ?? '+380956686191';
        $result_validate = $this->validatePhoneNumber($phoneNumber);
        if (!$result_validate) {
            return response()->json(
                [
                    'error',
                    'data' => 'Number is incorrect',
                ]);
        }

        $code = random_int(1001, 9995);
        Session::put('code_verification', $code);
        $message = 'Твой код активации: ' . $code;

        if (env('APP_DEBUG')) {
            return response()->json(
                [
                    'data' => $message,
                ]
            );
        }

        SmsService::sendSms($phoneNumber, $message);
        return response()->json(
            [
                'data' => [],
            ]);

    }

    private function validatePhoneNumber($phoneNumber)
    {
        $pattern = '/^\+380\d{9}$/';
        return preg_match($pattern, $phoneNumber);
    }
}
