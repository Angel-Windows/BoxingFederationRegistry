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
        'sports_institutions' => [
            'name' => 'sports_institutions',
            'tag' => 'custom-select',
            'placeholder' => 'Спортивний заклад',
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
        'history_works' => [
            'title' => 'Історія місць роботи',
            'name' => 'history_works',
            'tag' => 'history_works',
            'type' => 'history_works',
            'class' => 'fool',
            'placeholder' => 'Історія місць роботи',
            'data' => [],
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
            'tag' => 'select-box',
            'placeholder' => 'Вагова категорія',
            'option' => [
                'Перша вага (Light Fly) 46 - 49',
                'Найлегша вага (Fly) 49 - 52',
                'Найлегша (Bantam Weight)    52 - 56',
                'Легка вага (Light) 56 - 60',
                'Перша напівсередня (Light Welter)    60 - 64',
                'Напівсередня (Welter) 64 - 69',
                'Середня (Middle) 69 -75',
                'Перша важка (Light Heavy)    75 - 81',
                'Важка (Heavy) 81 - 91',
                'Супер важка (Super Heavy)    91 -',
                'Pin 44 - 46',
                '',
                'Перша найлегша (Light Fly)    46 - 48',
                '',
                'Найлегша (Fly) 48 - 50',
                'Перша легша вага (Light Bantam) 50 - 52',
                'Легша (Вага півня) 52 - 54',
                'Напівлегка вага (Feather weight) 54 - 57',
                'Легка (Light weight) 57 - 60',
                'Перша напівсередня (Light Welter)    60 - 63',
                'Напівсередня (Welter) 63 - 66',
                'Перша середня (Light Middle) 66 - 70',
                'Середня (Middle) 70 - 75',
                'Перша важка (Light Heavy)    75 - 80',
                'Важка (Heavy) 80 -',
                'Перша найлегша вага (Light Fly) 45     - 48',
                'Найлегша вага (Fly) 48 - 51',
                'Легша (Bantam) 51 - 54',
                'Напівлегка (Feather)    54 - 57',
                'Легка (Light) 57 - 60',
                'Перша напівсередня (Light Welter)    60 - 64',
                'Напівсередня (Welter) 64 - 69',
                'Середня (Middle) 69 - 75',
                'Перша важка (Light Heavy)    75 - 81',
                'Важка (Heavy) 81 -',
                'Міні Вага Мухи (Mini Fly Weight) -    47.63',
                'Перша найлегша вага (Junior Fly Weight) 47.63 - 48.99',
                'Найлегша вага (Fly Weight)    48.99 - 50.8',
                'Перша легша вага (Junior Bantam Weight) 50.8 - 52.16',
                'Легша вага (Bantam Weight) 52.16 - 53.52',
                'Перша напівлегка вага (Junior Feather Weight) 53.52 - 55.34',
                'Напівлегка вага (Feather Weight) 55.34 - 57.15',
                'Перша легка вага (Junior Light Weight) 57.15 - 58.97',
                'Легка вага (Light Weight) 58.97 - 61.24',
                'Перша Напівсередня вага (Junior Welterweight) 61.24 - 63.5',
                'Напівсередня вага (Welterweight) 63.5 - 66.68',
                'Перша середня вага (Junior Middle Weight) 66.68 - 69.85',
                'Середня вага (Middle Weight) 69.85 - 72.58',
                'Друга Середня вага (Sup. Middle Weight) 72.58 - 76.2',
                'Перша важка вага (Light Heavy weight) 76.2 - 79.38',
                'Важка вага (Junior Heavy weight) 79.38 - 90.72',
                'Супер важка вага (Heavy Weight) 91.17 -',
            ],

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
        'employees' => [
            'title'=> 'Працівники федерації',
            'checkbox_type' => 'revert',
            'name' => 'employees',
            'tag' => 'checkbox-list',
            'size' => 'fool',
            'placeholder' => 'Працівники федерації',
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
    public function getDefaultArrayData($name_type = '', $data = []): array
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

        foreach (array_merge($return, $this->DataTypeInputs) as $key => $data_input) {
            foreach ($data_input as $key_opt => $item_opt) {
                $data[$key][$key_opt] = $item_opt;
            }
        }
        return $data;
    }

}
