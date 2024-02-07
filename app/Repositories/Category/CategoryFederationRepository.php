<?php

namespace App\Repositories\Category;

use App\Models\Category\CategoryTrainer;
use App\Models\Class\BoxFederation;
use App\Models\Class\ClassType;
use App\Models\Linking\LinkingMembers;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Services\MyAuthService;
use App\Traits\CategoryUITrait;

class CategoryFederationRepository implements CategoryRepositoryInterface
{
    use CategoryUITrait;

    /**
     * @var null
     */
    public $category_type_id;
    public function __construct()
    {
        $this->category_type_id = ClassType::getIdCategory('box_federations');
    }

    public $data = [
        'name' => [
            'name' => 'name',
            'tag' => 'input',
            'size' => 'fool',
            'placeholder' => 'Назва федерації',
        ], 'phone' => [
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
        'federation' => [
            'name' => 'federation',
            'tag' => 'custom-select',
            'placeholder' => 'Підпорядковані федерації',

            'option' => [
                'box' => 'Бокс',
                'school-box' => 'Школа бокса',
                'yoga' => 'Йога',
            ],
        ],
        'site' => [
            'name' => 'site',
            'tag' => 'input',
            'placeholder' => 'Вебсайт',
        ],
        'address' => [
            'name' => 'address',
            'tag' => 'custom-select',
            'placeholder' => 'Адреса федерації',
            'autocomplete' => 'street-address',
            'size' => 'fool',
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
        'street' => [
            'name' => 'street',
            'tag' => 'custom-select',
            'placeholder' => 'Вулиця/провулок/проспект',
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
        'members' => [
            'name' => 'members',
            'tag' => 'custom-select',
            'size' => 'fool',
            'placeholder' => 'Учасники федерації',
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
                    $table['director'],
                    $table['phone'],
                    $table['email'],
                    $table['federation'],
                    $table['edrpou'],
                    $table['site'],
                    $table['city'],
                    $table['street'],
                    $table['house_number'],
                    $table['apartment_number'],
                    $table['members'],
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

        $new_data['email']['value'] = $category_data->email ?? "";

        $new_data['phone']['value'] = $category_data->phone ?? "";


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
        $new_data['director']['value'] = $category_data->director ?? "";
        $new_data['address']['value'] = $fool_address;
        $new_data['federation']['value'] = $category_data->federation ?? "";

        $new_data['edrpou']['value'] = $category_data->edrpou ?? "";
        $new_data['site']['value'] = $category_data->site ?? "";

        return $new_data;
    }

    private function created_view($table, $id): array
    {

        $members_works = LinkingMembers::leftJoin('category_trainers', 'category_trainers.id', 'linking_members.member_id')
            ->where('linking_members.category_id', $id)
            ->where('linking_members.category_type', $this->category_type_id)
                ->select(
                    'linking_members.*',
                    'category_trainers.name',
                    'category_trainers.phone',
                    'category_trainers.email',
                    'category_trainers.logo',
                )
                ->get();

        $works = [];
        foreach ($members_works as $member) {
            $works[] = [$member->logo, $member->name, $member->role, $member->phone, $member->email];
        }
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
                    ], [
                        'type' => 'table',
                        'data' => [
                            'body' => [
                                [
                                    $table['director']['placeholder'],
                                    $table['director']['value'] ?? '',
                                ], [
                                    $table['address']['placeholder'],
                                    $table['address']['value'] ?? '',
                                ], [
                                    $table['federation']['placeholder'],
                                    $table['federation']['value'] ?? '',
                                ], [
                                    $table['edrpou']['placeholder'],
                                    $table['edrpou']['value'] ?? '',
                                ], [
                                    $table['site']['placeholder'],
                                    $table['site']['value'] ?? '',
                                ],
                            ],
                        ],
                    ],
                ],
            ], [
                'title' => 'Працівники федерації',
                'data_wrapper' => [
                    [
                        'type' => 'todo_table',
                        'button_add' => '',

                            'data' => [
                            'thead' => ['ПІП', '', 'Посада', 'Телефон', 'Пошта'],
                            'body' => $works,
                        ],
                    ],
                ],
            ],
        ];
    }

    public function get_data($data): array
    {
        $type = $data['type'] ?? '';
        $category = BoxFederation::find($data['id']);
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
                $create = $this->created_view($table, $data['id']);
                break;
        }


        return [
            'table' => $create,
            'more_data' => $more_data
        ];
    }
}
