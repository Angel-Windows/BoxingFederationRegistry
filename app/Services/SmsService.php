<?php
namespace App\Services;

use Infobip\Api\SmsApi;
use Infobip\ApiException;
use Infobip\Model\SmsAdvancedTextualRequest;
use Infobip\Model\SmsDestination;
use Infobip\Model\SmsTextualMessage;
use Infobip\Configuration;

class SmsService
{
    public static function sendSms($phoneNumber, $message): \Exception|\Infobip\Model\SmsResponse|\Infobip\Model\ApiException|ApiException|null
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
