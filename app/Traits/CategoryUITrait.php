<?php

namespace App\Traits;

trait CategoryUITrait
{
    public static function getButtons(array $arr): array
    {
        $data_phones = [];

        foreach ($arr as $key => $item_category) {
            if (isJson($item_category)) {
                try {
                    $items = json_decode($item_category, true, 512, JSON_THROW_ON_ERROR);
                } catch (\JsonException $e) {
                }
            } else {
                $items = [$item_category];
            }

            foreach ($items as $item) {
                switch ($key) {
                    case 'phones':
                        $data_phones[] = [
                            'link' => '',
                            'logo' => 'img/phone.svg',
                            'text' => formatPhone($item),
                        ];
                        break;
                    case 'emails':
                        $data_phones[] = [
                            'link' => '',
                            'logo' => 'img/mail.svg',
                            'text' => $item,
                        ];
                        break;
                }
            }
        }
        return $data_phones;
    }

    public array $monthsUkrainian = [
        'Січень',
        'Лютий',
        'Березень',
        'Квітень',
        'Травень',
        'Червень',
        'Липень',
        'Серпень',
        'Вересень',
        'Жовтень',
        'Листопад',
        'Грудень'
    ];

    public function set_month($date): string
    {
        $date_split = explode('-', $date);
        $month_index = (int)$date_split[1] - 1;
        $year = $date_split[0];

        return $this->monthsUkrainian[$month_index] . ' ' . $year;
    }
}
