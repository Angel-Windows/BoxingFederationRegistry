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
        $new_phoned = '+380 (34) 1234-132';
        $operators = ['93', '95', '97', '99'];
        $operator = $operators[random_int(0, (count($operators) - 1))];
        $phones1  = random_int(1000, 9999);
        $phones2  = random_int(100, 999);

        return "+380 ($operator) $phones1-$phones2";

        $phones = [];
        $count_phones = random_int(1, $max_count);

        do {
            $phones[] = $operators[random_int(0, (count($operators) - 1))] . random_int(1000000, 9999999);

        } while (count($phones) < $count_phones);
        return $phones[0];
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

if (!function_exists('randomAddress')) {
    function randomAddress(): bool|string
    {
        $faker = \Faker\Factory::create();

        return json_encode([
            'city' => random_int(0,11),

            'street' => $faker->streetName,
            'house_number' => random_int(1, 100),
            'apartment_number' => random_int(1, 100),
        ]);
    }
}

if (!function_exists('MyAsset')) {
    function MyAsset($url, $type = 'no_img'): bool|string
    {
        return route('config.show-img', ['filename' => $url, 'type'=>$type]);
    }
}
if (!function_exists('RandPhoto')) {
    function RandPhoto(): bool|string
    {
        $img_arr = Storage::files('photos');
        $rand_img = array_rand($img_arr);
        return $img_arr[$rand_img];
    }
}

