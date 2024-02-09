<?php

namespace App\Repositories\Category;

use App\Models\Category\CategorySportsman;
use App\Models\Category\CategoryTrainer;
use App\Models\Class\BoxFederation;
use App\Models\Class\ClassType;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Traits\CategoryUITrait;
use App\Traits\FondyTrait;

class SportsmanFederationRepository implements CategoryRepositoryInterface
{
    use CategoryUITrait;

    private $is_default_length = 'fool';
    public $table_model = CategorySportsman::class;

    public function __construct()
    {
        $this->category_type_id = ClassType::getIdCategory('category_sports_institutions');
        $this->data = array_merge($this->data, $this->getDefaultArrayData($this->is_default_length));
    }

    private $data = [
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
        'weight' => [
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
            'placeholder' => 'Місце народження',
        ],
        'passport' => [
            'name' => 'passport',
            'tag' => 'input',
            'placeholder' => 'Паспорт український, серія/номер',
        ],
        'trainer' => [
            'name' => 'trainer',
            'tag' => 'input',
            'placeholder' => 'Мій тренер',
        ],
        'achievements' => [
            'name' => 'achievements',
            'tag' => 'input',
            'placeholder' => 'Історія досягнень',
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
            'placeholder' => 'Моя школа',
            'size' => 'fool',
            'option' => [
            ],
        ],
        'rank' => [
            'name' => 'rank',
            'tag' => 'select-box',
            'placeholder' => 'Спортивне звання',
            'size' => 'fool',
            'option' => [
                'Заслужений майстер спорту України',
                'Майстер спорту України міжнародного класу',
                'Майстер спорту України',
                'Кандидат у майстри спорту України',
                'Перший розряд',
                'Другий розряд',
                'Третій розряд',
                'Перший юнацький розряд',
                'Другий юнацький розряд',
                'Третій юнацький розряд',
            ],
        ],
    ];


    private function get_edit($table, $id): array
    {
        $table['federation']['option'] = BoxFederation::pluck('name', 'id');
        return [
            [
                'type' => '',
                'data_block' =>
                    [
                        [
                            'type' => 'table',
                            'data' => [
                                $table['first_name'],
                                $table['phone'],
                                $table['email'],
                                $table['birthday'],
                                $table['gender'],
                                $table['weight'],
                                $table['height'],
                                $table['weight_category'],
                                $table['address_birth'],
                                $table['address'],
                                $table['passport'],
                                $table['federation'],
                                $table['trainer'],
                                $table['school'],
                                $table['achievements'],
                                $table['rank'],
                            ],
                        ],[
                            'title' => 'Місце народження',
                            'type' => 'table',
                            'data' => [
                                $table['first_name'],
                            ],
                        ],[
                            'title' => 'Адреса проживання',
                            'type' => 'table',
                            'data' => [
                                $table['first_name'],
                            ],
                        ],[
                            'title' => 'Паспорт український',
                            'type' => 'table',
                            'data' => [
                                $table['first_name'],
                            ],
                        ],[
                            'title' => 'Паспорт закордонний',
                            'type' => 'table',
                            'data' => [
                                $table['first_name'],
                            ],
                        ],[
                            'title' => 'Сім’я',
                            'button' => 'add-family',
                            'type' => 'table',
                            'data' => [
                                $table['first_name'],
                            ],
                        ],
                    ],
            ]
        ];
    }

    public function edit($id, $request, $type): array
    {
        $category = self::validate_category($request, $this->table_model, $id);

        $category->qualification = $request->input('qualification');
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

        $this->getDefaultValue($new_data, $category_data, $this->is_default_length);

        $this->GetValueInputs($category_data->school , 'school', $new_data);
        $this->GetValueInputs($category_data->federation , 'federation', $new_data);
        $this->GetValueInputs($category_data->birthday , 'birthday', $new_data);
        $this->GetValueInputs($category_data->gender , 'gender', $new_data);
        $this->GetValueInputs($category_data->weight , 'weight', $new_data);
        $this->GetValueInputs($category_data->height , 'height', $new_data);
        $this->GetValueInputs($category_data->weight_category , 'weight_category', $new_data);
        $this->GetValueInputs($category_data->address_birth , 'address_birth', $new_data);
        $this->GetValueInputs($category_data->passport , 'passport', $new_data);
        $this->GetValueInputs($category_data->trainer , 'trainer', $new_data);
        $this->GetValueInputs($category_data->achievements , 'achievements', $new_data);
        $this->GetValueInputs($category_data->rank , 'rank', $new_data);


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
                                    $table['birthday']['placeholder'],
                                    $table['birthday']['value'] ?? '',
                                ], [
                                    $table['gender']['placeholder'],
                                    $table['gender']['value'] ?? '',
                                ], [
                                    $table['weight']['placeholder'],
                                    $table['weight']['value'] ?? '',
                                ], [
                                    $table['height']['placeholder'],
                                    $table['height']['value'] ?? '',
                                ],[
                                    $table['weight_category']['placeholder'],
                                    $table['weight_category']['value'] ?? '',
                                ], [
                                    $table['address_birth']['placeholder'],
                                    $table['address_birth']['value'] ?? '',
                                ],  [
                                    $table['address']['placeholder'],
                                    $table['address']['value'] ?? '',
                                ], [
                                    $table['federation']['placeholder'],
                                    $table['federation']['value'] ?? '',
                                ], [
                                    $table['trainer']['placeholder'],
                                    $table['trainer']['value'] ?? '',
                                ],[
                                    $table['school']['placeholder'],
                                    $table['school']['value'] ?? '',
                                ],[
                                    $table['achievements']['placeholder'],
                                    $table['achievements']['value'] ?? '',
                                ],[
                                    $table['rank']['placeholder'],
                                    $table['rank']['value'] ?? '',
                                ],
                            ],
                        ],
                    ],
                ],
            ], [
                'title' => 'Сім’я',
                'data_wrapper' => [
                    [
                        'type' => 'table',
                        'class' => 'no-width no-wrap',
                        'data' => [
                            'thead' => ['ПІП', 'Статус', 'Телефон'],
                            'body' => [
                                [
                                    'Кравчук Віталій Вікторович',
                                    'Тато',
                                    '097 777-77-77',
                                ]
                            ],
                        ],
                    ],
                ],
            ],[
                'title' => 'Історія медичних допусків',
                'data_wrapper' => [
                    [
                        'type' => 'table',
                        'class' => 'no-width history-work no-wrap',
                        'data' => [
                            'thead' => ['ПІП', 'Статус', '', 'Телефон'],
                            'body' => [
                                [
                                    'Кравчук Віталій Вікторович',
                                    'Тато',
                                    '-',
                                    '097 777-77-77',
                                ]
                            ],
                        ],
                    ],
                ],
            ],[
                'title' => 'Історія страхових полісів',
                'data_wrapper' => [
                    [
                        'type' => 'table',
                        'class' => 'no-width history-work no-wrap',
                        'data' => [
                            'thead' => ['ПІП', 'Статус', '', 'Телефон'],
                            'body' => [
                                [
                                    'Кравчук Віталій Вікторович',
                                    'Тато',
                                    '-',
                                    '097 777-77-77',
                                ]
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
            'more_data' => $more_data,
        ];
    }

}
