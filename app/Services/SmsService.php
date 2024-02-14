<?php
namespace App\Services;

use Infobip\Api\SmsApi;
use Infobip\ApiException;
use Infobip\Model\SmsAdvancedTextualRequest;
use Infobip\Model\SmsDestination;
use Infobip\Model\SmsTextualMessage;
use Infobip\Configuration;
use Illuminate\Support\Facades\Http;
class SmsService
{
    public static function sendSms($phoneNumber, $message): \Exception|\Infobip\Model\SmsResponse|\Infobip\Model\ApiException|ApiException|null
    {
        $response = Http::get('https://api.turbosms.ua/message/send.json', [
            'token' => 'fc4123507284046d5222ddd4ef87a83445b584e4',
            'recipients' => [
                '380956686191'
            ],
            'sms' => [
                'sender' => 'TurboSMS',
                'text' => 'TurboSMS вітає Вас!'
            ],

            'REQUIRED_TOKEN' => 'fc4123507284046d5222ddd4ef87a83445b584e4',
            'TOKEN' => 'fc4123507284046d5222ddd4ef87a83445b584e4',
            // Убедитесь, что это ваш действительный токен
        ]);

        $body = $response->body();

        $status = $response->status();

        $headers = $response->headers();

//        https://api.turbosms.ua/message/send.json?recipients[0]=380956686191&sms[sender]=TurboSMS&sms[text]=TurboSMS+%D0%B2%D1%96%D1%82%D0%B0%D1%94+%D0%92%D0%B0%D1%81%21&token=fc4123507284046d5222ddd4ef87a83445b584e4
//        https://api.turbosms.ua/message/send.json?recipients[0]=380678998668&recipients[1]=380503288668&recipients[2]=380638998668&sms[sender]=TurboSMS&sms[text]=TurboSMS+%D0%B2%D1%96%D1%82%D0%B0%D1%94+%D0%92%D0%B0%D1%81%21&token=AUTH_TOKEN

        dd($response,$body, $status, $headers);
    }

    public static function infobipSendSms($phoneNumber, $message): \Exception|\Infobip\Model\SmsResponse|\Infobip\Model\ApiException|ApiException|null
    {
        $configuration = new Configuration(
            host: 'https://qyqprm.api.infobip.com',
            apiKey: env('INFOBIP_API_KEY', 'key'),
        );
        $sendSmsApi = new SmsApi(config: $configuration);
        $message = new SmsTextualMessage(
            destinations: [new SmsDestination(to: $phoneNumber)],
            from: 'BoxPlatform',
            text: $message
        );

        $request = new SmsAdvancedTextualRequest(messages: [$message]);

        try {
            $smsResponse = $sendSmsApi->sendSmsMessage($request);
            return $smsResponse;

        } catch (ApiException $apiException) {
            return $apiException;
            // HANDLE THE EXCEPTION
        }
    }

}
