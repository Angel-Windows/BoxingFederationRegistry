<?php

namespace App\Repositories\Category;

use App\Models\Category\CategoryJudge;
use App\Models\Category\CategoryTrainer;
use App\Models\Class\ClassType;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Traits\CategoryUITrait;
use App\Traits\FondyTrait;

class CategoryJudgeRepository implements CategoryRepositoryInterface
{
    use CategoryUITrait;
    private $is_default_length = 'fool';
    public $table_model = CategoryJudge::class;
    public function __construct(){
        $this->category_type_id = ClassType::getIdCategory('category_sports_institutions');
        $this->data = array_merge($this->data, $this->getDefaultArrayData($this->is_default_length));
    }
    private $data = [

        'qualification' => [
            'name' => 'qualification',
            'tag' => 'select-box',
            'placeholder' => 'Кваліфікація',
            'option' => [
                'Юний спортивний суддя',
                'Спортивний суддя другої категорії',
                'Спортивний суддя першої категорії',
                'Спортивний суддя Національної категорії',
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
            'tag' => 'select-box',
            'placeholder' => 'Державні, почесні звання, спортивні звання та розряди',
            'size' => 'fool',
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
            'tag' => 'select-box',
            'class' => 'no-active',
            'placeholder' => 'Державні заохочення',
            'size' => 'fool',
            'option' => [
                'box' => 'Бокс',
                'school-box' => 'Школа бокса',
                'yoga' => 'Йога',
            ],
        ]
    ];



    private function get_edit($table, $id): array
    {
        return [
            [
                'type' => '',
                'data_block' =>
                    [
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
                    ],
            ],
        ];
    }

    public function edit($id, $request, $type): array
    {
        $category = self::validate_category($request, $this->table_model, $id);

        $category->qualification = $request->input('qualification');

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
        $this->getDefaultValue($new_data, $category_data, $this->is_default_length);

        $new_data['qualification']['value'] = $category_data->qualification ?? "";
        $new_data['school']['value'] = $category_data->school ?? "";
        $new_data['rank']['value'] = $category_data->rank ?? "";
        $new_data['gov']['value'] = $category_data->gov ?? "";

        return $new_data;
    }

    private function created_view($table, $id): array
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
                                ], [
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

    public function get_data($data, $request = null): array
    {
        $type = $data['type'] ?? '';
        $category = $this->table_model::find($data['id']);
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
            case 'register_page':
                $create = $this->get_edit($table, null);
                break;
            case 'edit_page':
                $create = $this->get_edit($table, $data['id']);
                break;
            case 'edit':
                $create = $this->edit($data['id'], $request, $type);
                break;
            case "preview" :
                $create = $this->created_view($table, $data['id']);
                break;
            default:
                $create = [];
        }


        return [
            'table' => $create,
            'modeles' => $this->table_model,
            'more_data' => $more_data
        ];
    }
}
