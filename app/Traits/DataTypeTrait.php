<?php

namespace App\Traits;



trait DataTypeTrait
{
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
    private $city_arr = [
        "Київ",
        "Харків",
        "Одеса",
        "Дніпро",
        "Донецьк",
        "Запоріжжя",
        "Львів",
        "Кривий Ріг",
        "Миколаїв",
        "Маріуполь",
        "Вінниця",
        "Полтава",
        "Чернігів",
        "Черкаси",
        "Житомир",
        "Суми",
        "Рівне",
        "Кам'янець-Подільський",
        "Луцьк",
        "Кременчук",
    ];
    public $DataTypeInputs = [
        'qualification' => [
            'name' => 'qualification',
            'tag' => 'select-box',
            'placeholder' => 'Кваліфікація',
            'option' => [
                'Заслужений тренер України',
                'Заслужений майстер спорту України',
                'Майстер спорту України міжнародного класу',
                'Майстер спорту України',
                'Кандидат у майстри спорту України',
                'Перший розряд',
                'Другий розряд',
                'Третій розряд',
                'Перший юнацький розряд',
                'Другий юнацький розряд',
                'Третій юнацький розряд'
            ]
            ,
        ],
        'federation' => [
            'name' => 'federation',
            'tag' => 'custom-select',
            'placeholder' => 'Моя федерація',
            'size' => 'fool',
            'option' => [
                'box' => 'Бокс',
                'school-box' => 'Школа бокса',
                'yoga' => 'Йога',
            ],
        ],
        'school' => [
            'name' => 'school',
            'tag' => 'custom-select',
            'placeholder' => 'Мої навчальні заклади',
            'size' => 'fool',
            'option' => [
            ],
        ],
        'sportsmen' => [
            'name' => 'sportsmen',
            'tag' => 'input',
            'placeholder' => 'Мої спортсмени',
            'size' => 'fool',
        ],
        'rank' => [
            'name' => 'rank',
            'tag' => 'select-box',
            'placeholder' => 'Державні, почесні звання, спортивні звання та розряди',
            'size' => 'fool',
            'class' => ' fool',
            'option' => [
                'Заслужений тренер України',
                'Заслужений майстер спорту України',
                'Майстер спорту України міжнародного класу',
                'Майстер спорту України',
                'Кандидат у майстри спорту України',
                'Перший розряд, Другий розряд',
                'Третій розряд',
                'Перший юнацький розряд',
                'Другий юнацький розряд',
                'Третій юнацький розряд',
            ],
        ],
        'gov' => [
            'name' => 'gov',
            'tag' => 'no-active',
            'placeholder' => 'Державні заохочення',
            'size' => 'fool',
        ],
        'birthday' => [
            'name' => 'birthday',
            'tag' => 'input',
            'placeholder' => 'Дата народження',
        ],
        'gender' => [
            'name' => 'gender',
            'tag' => 'select-box',
            'placeholder' => 'Стать',
            'option' => [
                'Хлопець',
                'Дівчина',
            ],
        ],
        'arm_height' => [
            'name' => 'arm_height',
            'tag' => 'input',
            'placeholder' => 'Розмах рук',
        ], 'weight' => [
            'name' => 'weight',
            'tag' => 'input',
            'placeholder' => 'Вага',
        ],
        'height' => [
            'name' => 'height',
            'tag' => 'input',
            'placeholder' => 'Ріст',
        ],
        'weight_category' => [
            'name' => 'weight_category',
            'tag' => 'input',
            'placeholder' => 'Вагова категорія',
        ],
        'address_birth' => [
            'name' => 'address_birth',
            'tag' => 'input',
            'type' => 'fool',
            'class' => 'fool',
            'placeholder' => 'Місце народження',
        ],
        'passport' => [
            'name' => 'passport',
            'tag' => 'input',
            'placeholder' => 'Паспорт український, серія/номер',
        ],
        'foreign_passport' => [
            'name' => 'foreign_passport',
            'tag' => 'input',
            'placeholder' => 'Паспорт закордоний, серія/номер',
        ],
        'trainer' => [
            'name' => 'trainer',
            'tag' => 'custom-select',
            'placeholder' => 'Мій тренер',
            'size' => 'fool',
            'option' => [
                'box' => 'Бокс',
                'school-box' => 'Школа бокса',
                'yoga' => 'Йога',
            ],

        ],

        'achievements' => [
            'name' => 'achievements',
            'tag' => 'input',
            'placeholder' => 'Історія досягнень',
        ],
        'director' => [
            'name' => 'director',
            'tag' => 'input',
            'placeholder' => 'Президент',
        ],
        'edrpou' => [
            'name' => 'edrpou',
            'tag' => 'input',
            'placeholder' => 'Код за ЄДРПОУ',
        ],
        'site' => [
            'name' => 'site',
            'tag' => 'input',
            'placeholder' => 'Вебсайт',
        ],
        'members' => [
            'name' => 'members',
            'tag' => 'custom-select',
            'size' => 'fool',
            'placeholder' => 'Учасники федерації',
        ],
        'type' => [
            'name' => 'type',
            'tag' => 'select-box',
            'placeholder' => 'Тип закладу',
            'option' => [
                'Спеціалізована',
                'Олімпійська ',
                'Параолімпійська',
                'Середня загальноосвітня школа-інтернат/ліцей-інтернат спортивного профілю',
                'Училище спортивного профілю  ',
                'Спортивний ліцей',
                'Професійний коледж (коледж) спортивного профілю',
                'Фаховий коледж',

            ],
        ],
        'category' => [
            'name' => 'category',
            'tag' => 'select-box',
            'placeholder' => 'Категорія',
            'option' => [
                'Дитячо-юнацька спортивна школа',
                'Спеціалізована дитячо-юнацька спортивна школа олімпійського резерву',
                'Обласний центр олімпійської підготовки',
                'Центр олімпійської підготовки',
                'Школа вищої спортивної майстерності',
                'Спортивний клуб',

            ],
        ],
    ];
    public function getDefaultArrayData($name_type = '', $rf = []): array
    {
        $return = [];
        $return = array_merge($return, [
            'address' => [
                'name' => 'address',
                'tag' => 'input',
                'placeholder' => 'Адреса проживання',
                'autocomplete' => 'street-address',
                'size' => 'fool',

            ],
            'city' => [
                'name' => 'city',
                'tag' => 'select-box',
                'placeholder' => 'Місто',
                'size' => 'fool',
                'option' => $this->city_arr,

            ],
            'street' => [
                'name' => 'street',
                'size' => 'fool',
                'tag' => 'input',
                'placeholder' => 'Вулиця/провулок/проспект',

            ],
            'house_number' => [
                'name' => 'house_number',
                'tag' => 'input',
                'placeholder' => 'Номер будинку',

            ],
            'apartment_number' => [
                'name' => 'apartment_number',
                'tag' => 'input',
                'placeholder' => 'Номер квартири',
            ],
        ]);
        if ($name_type === 'fool') {
            $return = array_merge($return, [
                'last_name' => [
                    'name' => 'last_name',
                    'tag' => 'input',
                    'placeholder' => 'Прізвище',
                ],
                'first_name' => [
                    'name' => 'first_name',
                    'tag' => 'input',
                    'placeholder' => 'Імя',
                ],
                'surname' => [
                    'name' => 'surname',
                    'tag' => 'input',
                    'placeholder' => 'По батькові',
                ],
                'phone' => [
                    'name' => 'phone',
                    'tag' => 'input',
                    'placeholder' => 'Номер телефону',
                    'logo' => 'img/phone.svg'
                ],
                'email' => [
                    'name' => 'email',
                    'tag' => 'input',
                    'placeholder' => 'E-mail',
                    'logo' => 'img/mail.svg'
                ],
            ]);
        } else {
            $return = array_merge($return, [
                'name' => [
                    'name' => 'name',
                    'tag' => 'input',
                    'placeholder' => 'Назва закладу',
                ],
                'phone' => [
                    'name' => 'phone',
                    'tag' => 'input',
                    'placeholder' => 'Номер телефону',
                    'logo' => 'img/phone.svg'
                ],
                'email' => [
                    'name' => 'email',
                    'tag' => 'input',
                    'placeholder' => 'E-mail',
                    'logo' => 'img/mail.svg'
                ],
            ]);

        }
        $new_data = [];
        foreach (array_merge($return, $this->DataTypeInputs) as $key => $data_input) {
            foreach ($data_input as $key_opt => $item_opt) {
                $new_data[$key][$key_opt] = $item_opt;
            }
        }
        return $new_data;
    }

}
