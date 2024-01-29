<?php

namespace App\Repositories\Category;

use App\Models\Category\CategoryTrainer;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Traits\CategoryUITrait;

class CategoryTrainerRepository implements CategoryRepositoryInterface
{
    use CategoryUITrait;

    public function index($id): array
    {
        $user = CategoryTrainer::find($id);
        $history_work = [];


        foreach (json_decode($user->history_work) as $item) {
            $history_work[] = [
                $item->name, $this->set_month($item->start_work), '-', $this->set_month($item->end_work),
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
                                'data' => self::getButtons(['phones' => $user->phones, 'emails' => 'email@gmail.com'])
                            ],
                            [
                                'type' => 'table',
                                'data' => [
                                    'body' => [
                                        ['Кваліфікація', $user->qualification],
                                        ['Моя федерація', $user->federation],
                                        ['Адреса проживання', $user->address],
                                        ['Державні, почесні звання, спортивні звання та розряди', $user->rank],
                                        ['Державні заохочення', $user->gov],
                                        ['Мої навчальні заклади', $user->school],
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
                                        'body' => $history_work
                                    ]
                                ]
                            ]
                    ],
                ]
            ]
        ];
    }

    public function edit(): array
    {
        return [
            'last_name' => 'Прізвище',
            'first_name' => 'Імя',
            'surname' => 'По батькові',
            'phone' => 'Номер телефону',
            'email' => [
                'placeholder' => 'E-mail',
                'type' => 'email'
            ],
            'qualification' => [
                'placeholder' => 'Кваліфікація',
                'option' => [
                    'expert' => 'Експерт',
                    'trainer' => 'Тренер',
                    'kitchen' => 'Повар',
                ],
            ],
            'city' => [
                'placeholder' => 'Місто',
                'size' => 'fool',
                'option' => [
                    'zp' => 'Запоріжжя',
                    'pt' => 'Полтава',
                    'hr' => 'Херсон',
                    'vi' => 'Вінниця',
                ],
            ],
            'address' => [
                'placeholder' => 'Вулиця/провулок/проспект',
                'autocomplete' => 'street-address',
                'size' => 'fool',
                'option' => [
                    'zp' => 'Запоріжжя',
                    'pt' => 'Полтава',
                    'hr' => 'Херсон',
                    'vi' => 'Вінниця',
                ],
            ],
            'house_number' => [
                'placeholder' => 'Номер будинку',
                'option' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '4a' => '4a',
                ],
            ], 'apartment_number' => [
                'placeholder' => 'Номер квартири',
                'option' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '4a' => '4a',
                ],
            ], 'federation' => [
                'placeholder' => 'Моя федерація',
                'size' => 'fool',
                'option' => [
                    'box' => 'Бокс',
                    'school-box' => 'Школа бокса',
                    'yoga' => 'Йога',
                ],
            ], 'achievement' => [
                'placeholder' => 'Державні, почесні звання, спортивні звання та розряди',
                'size' => 'fool',
                'option' => [
                    'box' => 'Бокс',
                    'school-box' => 'Школа бокса',
                    'yoga' => 'Йога',
                ],
            ], 'state_incentives' => [
                'placeholder' => 'Державні заохочення',
                'size' => 'fool',
                'option' => [
                    'box' => 'Бокс',
                    'school-box' => 'Школа бокса',
                    'yoga' => 'Йога',
                ],
            ],
        ];
    }
}
