<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\MyAuthService;
use App\Services\SmsService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
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

//        if (!$result_validate) {
//            return response()->json(
//                [
//                    'log' => 'Number_No_correct',
//                    'error',
//                    'data' => 'Number is incorrect',
//                ]);
//        }

        $code = random_int(1001, 9995);

        Cache::put('code_verification', $code, now()->addSeconds(120));
        Cache::put('phone', $phoneNumber, now()->addSeconds(120));

        $message = 'Твой код активации: ' . $code;

//        if (env('APP_DEBUG')) {
            return response()->json(
                [
                    'log' => $message,
                ]
            );
//        }

//        SmsService::sendSms($phoneNumber, $message);
//        return response()->json(
//            [
//                'data' => [],
//            ]);

    }

    private function validatePhoneNumber($phoneNumber)
    {
        $pattern = '/^\+380\d{9}$/';
        return preg_match($pattern, $phoneNumber);
    }

    public function logout(): \Illuminate\Http\RedirectResponse
    {

        MyAuthService::Logout();
        return redirect()->back();
    }
    public function send_code(Request $request)
    {
        $code_verification = Cache::get('code_verification');
        $code_write = $request->code ?? null;
        $phone =  Cache::get('phone');
        if ($code_verification && $code_write && $phone && ($code_verification == $code_write)){
            MyAuthService::Auth($phone);
            return json_encode([
                'type' => 'Success',
            ]);
        }

        return json_encode([
            'type' => 'Error',
        ]);
    }
}
