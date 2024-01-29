<?php
namespace App\Repositories\Category;
use App\Models\Category\CategorySportsman;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Traits\CategoryUITrait;

class SportsmanFederationRepository implements CategoryRepositoryInterface
{
    use CategoryUITrait;
    public function index($id): array
    {
        $user = CategorySportsman::find($id);
        $history_medical = [];
        $history_insurances = [];

//
        for ($i = 0; $i < 3; $i++) {
            $history_medical[] = [
                'Кравчук Віталій Вікторович', '02 лютого 2015', '-', '12 січня 2018',
            ];
        }
        for ($i = 0; $i < 3; $i++) {
            $history_insurances[] = [
                'Кравчук Віталій Вікторович', '02 лютого 2015', '-', '12 січня 2018',
            ];
        }

        return [
            'name' => $user->name,
            'img' => [
                'class' => 'big_img',
                'link' => $user->logo
//                'link' => 'img/users_img/9284da0c7ca70f123c97200aa73fa3dc.png'
            ],
            'right_panel' => [
                [
                    'title' => null,
                    'data-wrapper' => [
                        'class' => '',
                        'data' => [
                            [
                                'type' => 'buttons',
                                'data' => self::getButtons(['phones' => $user->phones, 'emails' => $user->email])
                            ],
                            [
                                'type' => 'table',
                                'data' => [
                                    'body' => [
                                        ['Дата народження', $user->birthday],
                                        ['Стать', $user->gender],
                                        ['Вага', $user->weight],
                                        ['Розмах рук', ''],
                                        ['Ріст', $user->height],
                                        ['Вагова категорія', $user->weight_category],
                                        ['Місце народження', $user->address_birth],
                                        ['Адреса проживання', $user->address_address],
                                        ['Паспорт український, серія/номер', $user->passport],
                                        ['Паспорт закордоний, серія/номер', ''],
                                        ['Моя федерація', $user->federation],
                                        ['Мій тренер', $user->trainer],
                                        ['Моя школа', $user->school],
                                        ['Історія досягнень', $user->achievements],
                                        ['Спортивне звання', $user->rank],
                                    ]
                                ]
                            ]
                        ]
                    ],

                ],
                [
                    'title' => 'Сім’я',
                    'data-wrapper' => [
                        'class' => 'mini',
                        'data' =>
                            [
                                [
                                    'type' => 'table',
                                    'class' => 'no-wrap',
                                    'data' => [
                                        'thead' => ['ПІП', 'Статус', 'Телефон'],
                                        'body' => [
                                            ['Кравчук Віталій Вікторович', 'Тато', '097 734-77-33'],
                                            ['Кравчук Віталій Вікторович', 'Мама', '093 777-34-77'],
                                            ['Кравчук Віталій Вікторович', 'Сестра', '095 777-11-44'],
                                        ]
                                    ]
                                ]
                            ]
                    ],
                ],
                [
                    'title' => 'Історія місць роботи',
                    'data-wrapper' => [
                        'class' => 'mini',
                        'data' =>
                            [
                                [
                                    'type' => 'table',
                                    'class' => 'history-work no-wrap',
                                    'data' => [
                                        'thead' => ['Назва закладу', 'Початок', '', 'Кінець'],
                                        'body' => $history_medical
                                    ]
                                ]
                            ]
                    ],
                ], [
                    'title' => 'Історія страхових полісів',
                    'data-wrapper' => [
                        'class' => 'mini',
                        'data' =>
                            [
                                [
                                    'type' => 'table',
                                    'class' => 'history-work no-wrap',
                                    'data' => [
                                        'thead' => ['Назва закладу', 'Початок', '', 'Кінець'],
                                        'body' => $history_insurances
                                    ]
                                ]
                            ]
                    ],
                ],
            ]
        ];
    }
    public function edit(): array
    {
        return [];
    }
}
