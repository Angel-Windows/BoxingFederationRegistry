<?php

namespace App\Repositories\Category;

use App\Models\Category\CategorySportsInstitutions;
use App\Models\Category\CategoryTrainer;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Traits\CategoryUITrait;

class CategorySportsInstitutionsRepository implements CategoryRepositoryInterface
{
    use CategoryUITrait;

    private $data = [
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

        'type' => [
            'name' => 'type',
            'tag' => 'select-box',
            'placeholder' => 'Тип закладу',
            'option' => [
                'test',
                'temp',

            ],
        ],
        'category' => [
            'name' => 'category',
            'tag' => 'select-box',
            'placeholder' => 'Категорія',
            'option' => [
                'test',
                'temp',
            ],
        ],
        'edrpou' => [
            'name' => 'edrpou',
            'tag' => 'input',
            'placeholder' => 'Код за ЄДРПОУ',
        ],
        'director' => [
            'name' => 'director',
            'tag' => 'input',
            'placeholder' => 'Директор',
        ],
        'site' => [
            'name' => 'site',
            'tag' => 'input',
            'placeholder' => 'Веб сайт',
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


    ];

    private function get_edit($table): array
    {
        return [
            [
                'type' => 'table',
                'data' => [
                    $table['name'],
                    $table['type'],
                    $table['phone'],
                    $table['email'],
                    $table['category'],
                    $table['edrpou'],
                    $table['director'],
                    $table['site'],

                    $table['city'],
                    $table['address'],
                    $table['house_number'],
                    $table['apartment_number'],
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
        $category->federation = $request->input('federation');
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
        $new_data['name']['value'] =  $category_data->name ?? '';
        $new_data['phone']['value'] = $category_data->phone ?? "";
        $new_data['email']['value'] = $category_data->email ?? "";


        $new_data['category']['value'] = $category_data->category ?? "";
        $new_data['type']['value'] = $category_data->type ?? "";
        $new_data['edrpou']['value'] = $category_data->edrpou ?? "";
        $new_data['director']['value'] = $category_data->director ?? "";
        $new_data['site']['value'] = $category_data->site ?? "";


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
                                ], [
                                    $table['type']['placeholder'],
                                    $table['type']['value'] ?? '',
                                ],[
                                    $table['category']['placeholder'],
                                    $table['category']['value'] ?? '',
                                ],[
                                    $table['edrpou']['placeholder'],
                                    $table['edrpou']['value'] ?? '',
                                ],[
                                    $table['director']['placeholder'],
                                    $table['director']['value'] ?? '',
                                ],[
                                    $table['site']['placeholder'],
                                    $table['site']['value'] ?? '',
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
        $category = CategorySportsInstitutions::find($data['id']);
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
