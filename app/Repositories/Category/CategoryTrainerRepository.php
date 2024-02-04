<?php

namespace App\Repositories\Category;

use App\Models\Category\CategorySportsman;
use App\Models\Category\CategoryTrainer;
use App\Models\Category\Operations\LinkCategory;
use App\Models\Class\ClassType;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Traits\CategoryUITrait;

class CategoryTrainerRepository implements CategoryRepositoryInterface
{
    use CategoryUITrait;

    private $data = [
        [
            'type' => 'table',
            'data' => [
                [
                    'name' => 'last_name',
                    'tag' => 'input',
                    'text' => 'Прізвище',
//                        'value' => $fool_name[0] ?? ""
                ],
                [
                    'name' => 'first_name',
                    'tag' => 'input',
                    'text' => 'Імя',
//                        'value' => $fool_name[1] ?? ""
                ],
                [
                    'name' => 'surname',
                    'tag' => 'input',
                    'text' => 'По батькові',
//                        'value' => $fool_name[2] ?? ""
                ],
                [
                    'name' => 'phone',
                    'tag' => 'input',
                    'text' => 'Номер телефону',
//                        'value' => json_decode($user->phones)[0] ?? "",
                ],
                [
                    'name' => 'email',
                    'tag' => 'input',
                    'text' => 'E-mail',
//                        'value' => $user->email,
                ], [
                    'name' => 'qualification',
                    'tag' => 'custom-select',
                    'placeholder' => 'Кваліфікація',
//                        'value' => $user->qualification,
                    'option' => [
                        'expert' => 'Експерт',
                        'trainer' => 'Тренер',
                        'kitchen' => 'Повар',
                    ],
                ], [
                    'name' => 'city',
                    'tag' => 'custom-select',
                    'placeholder' => 'Місто',
                    'size' => 'fool',
//                        'value' => $address[0],
                    'option' => [
                        'zp' => 'Запоріжжя',
                        'pt' => 'Полтава',
                        'hr' => 'Херсон',
                        'vi' => 'Вінниця',
                    ],
                ], [
                    'name' => 'address',
                    'tag' => 'custom-select',
                    'placeholder' => 'Вулиця/провулок/проспект',
                    'autocomplete' => 'street-address',
                    'size' => 'fool',
//                        'value' => $address[1],
                    'option' => [
                        'zp' => 'Запоріжжя',
                        'pt' => 'Полтава',
                        'hr' => 'Херсон',
                        'vi' => 'Вінниця',
                    ],
                ], [
                    'name' => 'house_number',
                    'tag' => 'custom-select',
                    'placeholder' => 'Номер будинку',
//                        'value' => $address[2],
                    'option' => [
                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                        '4' => '4',
                        '4a' => '4a',
                    ],
                ], [
                    'name' => 'apartment_number',
                    'tag' => 'custom-select',
                    'placeholder' => 'Номер квартири',
//                        'value' => $address[3],
                    'option' => [
                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                        '4' => '4',
                        '4a' => '4a',
                    ],
                ], [
                    'name' => 'federation',
                    'tag' => 'custom-select',
                    'placeholder' => 'Моя федерація',
                    'size' => 'fool',
//                        'value' => $user->federation,
                    'option' => [
                        'box' => 'Бокс',
                        'school-box' => 'Школа бокса',
                        'yoga' => 'Йога',
                    ],
                ], [
                    'name' => 'rank',
                    'tag' => 'custom-select',
                    'placeholder' => 'Державні, почесні звання, спортивні звання та розряди',
                    'size' => 'fool',
//                        'value' => $user->rank,
                    'option' => [
                        'box' => 'Бокс',
                        'school-box' => 'Школа бокса',
                        'yoga' => 'Йога',
                    ],
                ], [
                    'name' => 'gov',
                    'tag' => 'custom-select',
                    'placeholder' => 'Державні заохочення',
                    'size' => 'fool',
//                        'value' => $user->gov,
                    'option' => [
                        'box' => 'Бокс',
                        'school-box' => 'Школа бокса',
                        'yoga' => 'Йога',
                    ],
                ]
            ],
        ],
    ];

    public function index($id): array
    {
        $user = CategoryTrainer::find($id);
        $history_work = [];


        foreach (json_decode($user->history_work, false, 512, JSON_THROW_ON_ERROR) as $item) {
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

    public function edit_page($id): array
    {
        $user = CategoryTrainer::find($id);
        if ($user) {
            $sportsman = CategorySportsman::inRandomOrder()->limit(random_int(2, 10))->get();
            $sportsman_list = [];
//            $history_work = [];
            foreach ($sportsman as $item) {
                $sportsman_list[] = [
                    'value' => 3,
                    'text' => $item->name
                ];
            }
//        foreach (json_decode($user->history_work) as $item) {
//            $history_work[] = [
//
//            ];
//        }
            $fool_name = explode(' ', $user->name);
            $address = explode('||', $user->address);
            return [
                [
                    'type' => 'table',
                    'data' => [
                        [
                            'name' => 'last_name',
                            'tag' => 'input',
                            'text' => 'Прізвище',
                            'value' => $fool_name[0] ?? ""
                        ],
                        [
                            'name' => 'first_name',
                            'tag' => 'input',
                            'text' => 'Імя',
                            'value' => $fool_name[1] ?? ""
                        ],
                        [
                            'name' => 'surname',
                            'tag' => 'input',
                            'text' => 'По батькові',
                            'value' => $fool_name[2] ?? ""
                        ],
                        [
                            'name' => 'phone',
                            'tag' => 'input',
                            'text' => 'Номер телефону',
                            'value' => json_decode($user->phones, false, 512, JSON_THROW_ON_ERROR)[0] ?? "",
                        ],
                        [
                            'name' => 'email',
                            'tag' => 'input',
                            'text' => 'E-mail',
                            'value' => $user->email,
                        ], [
                            'name' => 'qualification',
                            'tag' => 'custom-select',
                            'placeholder' => 'Кваліфікація',
                            'value' => $user->qualification,
                            'option' => [
                                'expert' => 'Експерт',
                                'trainer' => 'Тренер',
                                'kitchen' => 'Повар',
                            ],
                        ], [
                            'name' => 'city',
                            'tag' => 'custom-select',
                            'placeholder' => 'Місто',
                            'size' => 'fool',
                            'value' => $address[0],
                            'option' => [
                                'zp' => 'Запоріжжя',
                                'pt' => 'Полтава',
                                'hr' => 'Херсон',
                                'vi' => 'Вінниця',
                            ],
                        ], [
                            'name' => 'address',
                            'tag' => 'custom-select',
                            'placeholder' => 'Вулиця/провулок/проспект',
                            'autocomplete' => 'street-address',
                            'size' => 'fool',
                            'value' => $address[1],
                            'option' => [
                                'zp' => 'Запоріжжя',
                                'pt' => 'Полтава',
                                'hr' => 'Херсон',
                                'vi' => 'Вінниця',
                            ],
                        ], [
                            'name' => 'house_number',
                            'tag' => 'custom-select',
                            'placeholder' => 'Номер будинку',
                            'value' => $address[2],
                            'option' => [
                                '1' => '1',
                                '2' => '2',
                                '3' => '3',
                                '4' => '4',
                                '4a' => '4a',
                            ],
                        ], [
                            'name' => 'apartment_number',
                            'tag' => 'custom-select',
                            'placeholder' => 'Номер квартири',
                            'value' => $address[3],
                            'option' => [
                                '1' => '1',
                                '2' => '2',
                                '3' => '3',
                                '4' => '4',
                                '4a' => '4a',
                            ],
                        ], [
                            'name' => 'federation',
                            'tag' => 'custom-select',
                            'placeholder' => 'Моя федерація',
                            'size' => 'fool',
                            'value' => $user->federation,
                            'option' => [
                                'box' => 'Бокс',
                                'school-box' => 'Школа бокса',
                                'yoga' => 'Йога',
                            ],
                        ], [
                            'name' => 'rank',
                            'tag' => 'custom-select',
                            'placeholder' => 'Державні, почесні звання, спортивні звання та розряди',
                            'size' => 'fool',
                            'value' => $user->rank,
                            'option' => [
                                'box' => 'Бокс',
                                'school-box' => 'Школа бокса',
                                'yoga' => 'Йога',
                            ],
                        ], [
                            'name' => 'gov',
                            'tag' => 'custom-select',
                            'placeholder' => 'Державні заохочення',
                            'size' => 'fool',
                            'value' => $user->gov,
                            'option' => [
                                'box' => 'Бокс',
                                'school-box' => 'Школа бокса',
                                'yoga' => 'Йога',
                            ],
                        ]
                    ],
                ], [
                    'title' => 'Мої спортсмени',
                    'data' => [
                        [
                            'tag' => 'checkbox-list',
                            'name' => 'sportsman[]',
                            'data' => $sportsman_list,
                        ]
                    ],


                ], [
                    'title' => 'Історія місць роботи',
                    'data' => [
                        [
                            'tag' => 'history-work',
                            'name' => 'history_work[]',
                            'data' => json_decode($user->history_work, false, 512, JSON_THROW_ON_ERROR)
                        ]
                    ],
                ],
            ];
        }

        return $this->get_data();
    }

    public function edit($id, $request, $type): array
    {
        $validate = self::validate_category($request);
        if ($validate['error']) {
            return [
                'error' => $validate['error']
            ];
        }

        if ($type === 'edit') {
            $category = CategoryTrainer::find($id);
        } else {
            $category = new CategoryTrainer();
        }

        $category->name = $request->input('first_name') . ' ' . $request->input('last_name') . ' ' . $request->input('surname');
        $category->logo = $validate['img_patch'];
        $category->phones = json_encode([$request->input('phone')], JSON_THROW_ON_ERROR);
        $category->email = $request->input('email');
        $category->qualification = $request->input('qualification');
        $category->address = $request->input('city') . "||" . $request->input('address') . "||" . $request->input('house_number') . "||" . $request->input('apartment_number');
        $category->federation = $request->input('federation');
        $category->rank = $request->input('rank');
        $category->gov = $request->input('gov');
        $category->save();

        if ($type === 'register'){
            $link_link = new LinkCategory();
            $link_link->setAddLinkAttribute($category->id, 'category_trainers');
        }
        return [
            'error' => null
        ];
    }

    public function get_data(): array
    {
        return $this->data;
    }
}
