<?php


if (!function_exists('customFunction')) {
    function customFunction()
    {
        // Ваш код глобальной функции здесь
        return 'Это моя глобальная функция!';
    }
}
if (!function_exists('getRandomPhone')) {
    function getRandomPhone($max_count = 1)
    {
        $phones = [];
        $count_phones = random_int(1, $max_count);
        $operators = ['93', '95', '97', '99'];
        do {
            $phones[] = $operators[random_int(0, (count($operators) - 1))] . random_int(1000000, 9999999);

        } while (count($phones) < $count_phones);
        return $phones;
    }
}

if (!function_exists('formatPhone')) {
    function formatPhone($phone = ""): string
    {

        if ($phone && strlen($phone) !== 9) {
            return $phone;
        }

        $countryCode = '0';
//        $countryCode = '+380';
        $areaCode = substr($phone, 0, 2);
        $firstPart = substr($phone, 2, 3);
        $secondPart = substr($phone, 5, 2);
        $thirdPart = substr($phone, 7, 2);

        return "$countryCode($areaCode)$firstPart-$secondPart-$thirdPart";
    }
}
if (!function_exists('isJson')) {
    function isJson($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}

