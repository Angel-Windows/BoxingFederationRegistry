<?php

namespace App\Repositories\Category;

use App\Models\Category\CategoryJudge;
use App\Models\Category\CategoryTrainer;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Traits\CategoryUITrait;
use App\Traits\FondyTrait;

class CategoryJudgeRepository implements CategoryRepositoryInterface
{
    use CategoryUITrait;

    private $data = [
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
        'qualification' => [
            'name' => 'qualification',
            'tag' => 'custom-select',
            'placeholder' => 'Кваліфікація',
            'option' => [
            ],
        ],
        'city' => [
            'name' => 'city',
            'tag' => 'select-box',
            'placeholder' => 'Місто',
            'size' => 'fool',
            'option' => [
                1 => "Київ",
                2 => "Харків",
                3 => "Одеса",
                4 => "Дніпро",
                5 => "Донецьк",
                6 => "Запоріжжя",
                7 => "Львів",
                8 => "Кривий Ріг",
                9 => "Миколаїв",
                10 => "Маріуполь",
                11 => "Вінниця",
                12 => "Полтава",
                13 => "Чернігів",
                14 => "Черкаси",
                15 => "Житомир",
                16 => "Суми",
                17 => "Рівне",
                18 => "Кам'янець-Подільський",
                19 => "Луцьк",
                20 => "Кременчук",
            ],
        ],
        'address' => [
            'name' => 'address',
            'tag' => 'custom-select',
            'placeholder' => 'Адреса проживання',
            'autocomplete' => 'street-address',
            'size' => 'fool',
            'option' => [
            ],
        ],
        'house_number' => [
            'name' => 'house_number',
            'tag' => 'custom-select',
            'placeholder' => 'Номер будинку',
            'option' => [
                ''
            ],
        ],
        'apartment_number' => [
            'name' => 'apartment_number',
            'tag' => 'custom-select',
            'placeholder' => 'Номер квартири',
            'option' => [
            ],
        ],

        'school' => [
            'name' => 'school',
            'tag' => 'custom-select',
            'placeholder' => 'Перелік навчальних закладів, які закінчив суддя',
            'size' => 'fool',
            'option' => [
            ],
        ],
        'rank' => [
            'name' => 'rank',
            'tag' => 'custom-select',
            'placeholder' => 'Державні, почесні звання, спортивні звання та розряди',
            'size' => 'fool',
            'option' => [
                'box' => 'Бокс',
                'school-box' => 'Школа бокса',
                'yoga' => 'Йога',
            ],
        ],
        'gov' => [
            'name' => 'gov',
            'tag' => 'custom-select',
            'placeholder' => 'Державні заохочення',
            'size' => 'fool',
            'option' => [
                'box' => 'Бокс',
                'school-box' => 'Школа бокса',
                'yoga' => 'Йога',
            ],
        ]
    ];

    private function get_edit($table): array
    {
        return [
            [
                'type' => 'table',
                'data' => [
                    $table['last_name'],
                    $table['first_name'],
                    $table['surname'],
                    $table['phone'],
                    $table['email'],
                    $table['qualification'],
                    $table['city'],
                    $table['address'],
                    $table['house_number'],
                    $table['apartment_number'],
                    $table['rank'],
                    $table['gov'],
                ],
            ],
        ];
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
        $category->rank = $request->input('rank');
        $category->gov = $request->input('gov');
        $category->save();


        return [
            'error' => null
        ];
    }

    private function get_value($table, $category_data): array
    {
        $new_data = $table;

        $name = explode(' ', $category_data->name ?? '');

        $address = json_decode($category_data->address ?? "");
        $fool_address = '';
        if (isset($address->city)) {
            $fool_address .= 'м. ' . $address->city;
        }
        if (isset($address->street)) {
            $fool_address .= ', ' . $address->street;
        }
        if (isset($address->house_number)) {
            $fool_address .= ' ' . $address->house_number;
        }
        if (isset($address->apartment_number)) {
            $fool_address .= ', кв. ' . $address->apartment_number;
        }

        $new_data['address']['value'] = $fool_address;

        $new_data['first_name']['value'] = $name[0] ?? '';
        $new_data['last_name']['value'] = $name[1] ?? '';
        $new_data['surname']['value'] = $name[2] ?? '';
        $new_data['phone']['value'] = $category_data->phone ?? "";
        $new_data['email']['value'] = $category_data->email ?? "";
        $new_data['qualification']['value'] = $category_data->qualification ?? "";
        $new_data['school']['value'] = $category_data->school ?? "";
        $new_data['rank']['value'] = $category_data->rank ?? "";
        $new_data['gov']['value'] = $category_data->gov ?? "";

        return $new_data;
    }

    private function created_view($table): array
    {
        return [
            [
                'title' => null,
                'data_wrapper' => [
                    [
                        'type' => 'buttons',
                        'data' => [
                            $table['phone'],
                            $table['email'],
                        ],
                    ],
                    [
                        'type' => 'table',
                        'data' => [
                            'body' => [
                                [
                                    $table['address']['placeholder'],
                                    $table['address']['value'] ?? '',
                                ],
                                [
                                    $table['qualification']['placeholder'],
                                    $table['qualification']['value'] ?? '',
                                ], [
                                    $table['rank']['placeholder'],
                                    $table['rank']['value'] ?? '',
                                ], [
                                    $table['gov']['placeholder'],
                                    $table['gov']['value'] ?? '',
                                ],  [
                                    $table['school']['placeholder'],
                                    $table['school']['value'] ?? '',
                                ],
                            ],
                        ],
                    ],
                ],
            ], [
                'title' => 'Історія місць роботи',
                'data_wrapper' => [
                    [
                        'type' => 'table',
                        'class' => 'history-work no-wrap',
                        'data' => [
                            'thead' => ['Назва закладу', 'Початок', '', 'Кінець'],

                            'body' => [
                                [
                                    $table['qualification']['placeholder'],
                                    $table['qualification']['value'] ?? '',
                                    '',
                                    $table['qualification']['value'] ?? '',
                                ], [
                                    $table['qualification']['placeholder'],
                                    $table['qualification']['value'] ?? '',
                                    '',
                                    $table['qualification']['value'] ?? '',
                                ], [
                                    $table['address']['placeholder'],
                                    $table['address']['value'] ?? '',
                                    '',
                                    $table['address']['value'] ?? '',
                                ], [
                                    $table['rank']['placeholder'],
                                    $table['rank']['value'] ?? '',
                                    '',
                                    $table['rank']['value'] ?? '',
                                ], [
                                    $table['gov']['placeholder'],
                                    $table['gov']['value'] ?? '',
                                    '',
                                    $table['gov']['value'] ?? '',
                                ], [
                                    $table['school']['placeholder'],
                                    $table['school']['value'] ?? '',
                                    '',
                                    $table['school']['value'] ?? '',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    public function get_data($data): array
    {
        $type = $data['type'] ?? '';
        $category = CategoryTrainer::find($data['id']);
        $more_data = [];

        if ($category) {
            $more_data = [
                'name' => $category->name,
                'phone' => $category->phone,
                'logo' => [
                    'link' => $category->logo,
                    'class' => 'big_img'
                ]
            ];
            $table = $this->get_value($this->data, $category);
        } else {
            $table = $this->data;
        }


        switch ($type) {
            case 'register':
                $create = $this->data;
                break;
            case 'edit_page':
                $create = $this->get_edit($table, $category);
                break;
            case "preview" :
                $create = $this->created_view($table);
                break;
        }


        return [
            'table' => $create,
            'more_data' => $more_data
        ];
    }
}
