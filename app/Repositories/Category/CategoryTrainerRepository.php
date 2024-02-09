<?php

namespace App\Repositories\Category;

use App\Http\Controllers\Page\TrainerController;
use App\Models\Category\CategoryTrainer;
use App\Models\Class\BoxFederation;
use App\Models\Class\ClassType;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Traits\CategoryUITrait;

/**
 * @property null $category_type_id
 */
class CategoryTrainerRepository implements CategoryRepositoryInterface
{
    use CategoryUITrait;


    private $is_default_length = 'fool';
    public $table_model = CategoryTrainer::class;

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
            'tag' => 'input',
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
            'class' => ' fool',
            'tag' => 'no-active',
            'placeholder' => 'Державні заохочення',
            'size' => 'fool',
        ]
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
                                $table['last_name'],
                                $table['first_name'],
                                $table['surname'],
                                $table['phone'],
                                $table['email'],
                                $table['qualification'],
                                $table['city'],
                                $table['street'],
                                $table['house_number'],
                                $table['apartment_number'],
                                $table['federation'],
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
        $this->GetValueInputs($category_data->qualification , 'qualification', $new_data);
        $this->GetValueInputs($category_data->school , 'school', $new_data);
        $this->GetValueInputs($category_data->rank , 'rank', $new_data);
        $this->GetValueInputs($category_data->sportsmen , 'sportsmen', $new_data);
        $this->GetValueInputs($category_data->federation , 'federation', $new_data);

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
                                    $table['qualification']['placeholder'],
                                    $table['qualification']['value'] ?? '',
                                ], [
                                    $table['federation']['placeholder'],
                                    $table['federation']['value'] ?? '',
                                ], [
                                    $table['address']['placeholder'],
                                    $table['address']['value'] ?? '',
                                ], [
                                    $table['city']['placeholder'],
                                    $table['city']['text'] ?? '',
                                ], [
                                    $table['rank']['placeholder'],
                                    $table['rank']['value'] ?? '',
                                ], [
                                    $table['gov']['placeholder'],
                                    $table['gov']['value'] ?? '',
                                ], [
                                    $table['school']['placeholder'],
                                    $table['school']['value'] ?? '',
                                ], [
                                    $table['sportsmen']['placeholder'],
                                    'asdf, asdf,acvzfv, sdfgsdfht, adaf cxvzrg',
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
                                    $table['federation']['placeholder'],
                                    $table['federation']['value'] ?? '',
                                    '',
                                    $table['federation']['value'] ?? '',
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
            'more_data' => $more_data,
        ];
    }
}
