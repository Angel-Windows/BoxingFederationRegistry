<?php

namespace App\Repositories\Category;

use App\Models\Category\CategorySportsInstitutions;
use App\Models\Category\CategorySportsman;
use App\Models\Category\CategoryTrainer;
use App\Models\Class\BoxFederation;
use App\Models\Class\ClassType;
use App\Models\Federation;
use App\Models\Linking\LinkingMembers;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Traits\CategoryUITrait;
use App\Traits\DataTypeTrait;

/**
 * @property null $category_type_id
 * @method static where(string $string, $sportsmen)
 * @method static whereIn(string $string, $sportsmen)
 */
class SportsmanFederationRepository implements CategoryRepositoryInterface
{
    use CategoryUITrait;
    use DataTypeTrait;

    private $is_default_length = 'fool';
    public $table_model = CategorySportsman::class;

    public function __construct()
    {
        $this->category_type_id = ClassType::getIdCategory('category_sports_institutions');
        $this->data = $this->getDefaultArrayData($this->is_default_length, $this->data_inputs);
    }

    private $data;

    private $data_inputs = [
        'rank' => [
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
        'city' => [
            'size' => 'fool'
        ],
        'street' => [
            'size' => 'fool'
        ],
        'family' => [
            'size' => 'fool'
        ], 'federation' => [
            'tag' => 'select-box',
        ], 'sports_institutions' => [
            'tag' => 'select-box',
        ],
    ];

    private function get_arr_federation($trainer_id): array
    {
        $linking_trainer = CategoryTrainer::find($trainer_id);

        $arr_federation = [];

        $old_id = $linking_trainer ? $linking_trainer->federation : null;

        if ($old_id) {
            $arr_federation[$old_id] = $old_id;
        }
        $max = 0;
        $linking_federation = null;
        while ($max < BoxFederation::count() - 1) {
            $linking_federation = BoxFederation::where('id', $old_id)
                ->whereNotIn('id', $arr_federation)
                ->first();

            if ($linking_federation) {
                $old_id = $linking_federation->federation;
                $arr_federation[$old_id] = $old_id;
            } else {
                break;
            }

            $max++;
        }


        return $arr_federation;

    }

    private function get_edit($table, $id, $model): array
    {
        $table['trainer']['option'] = CategoryTrainer::pluck('name', 'id');
        if (!$id) {
            $table['sports_institutions']['option'] = CategorySportsInstitutions::pluck('name', 'id');
            $table['federation']['option'] = BoxFederation::pluck('name', 'id');
            $table['family'] = null;
        } elseif (!$model->trainer){
            $table['sports_institutions']['option'] = CategorySportsInstitutions::pluck('name', 'id');
            $table['federation']['option'] = BoxFederation::pluck('name', 'id');
        }else {

            $linking = LinkingMembers::where('member_id', $model->trainer)
                ->where('category_type', ClassType::getIdCategory('category_sports_institutions'))
                ->pluck('category_id');
            if ($linking) {
                $table['sports_institutions']['option'] = CategorySportsInstitutions::whereIn('id', $linking)
                    ->pluck('name', 'id');
            } else {
                $table['sports_institutions']['option'] = CategorySportsInstitutions::pluck('name', 'id');
            }


            $arr_federation = $this->get_arr_federation($model->trainer);

            $table['federation']['option'] = BoxFederation::whereIn('id', $arr_federation)
                ->pluck('name', 'id')->all();

            if (empty($table['federation']['option'])) {
                $table['federation']['option'] = BoxFederation::pluck('name', 'id')->all();
            }
//            $table['federation']['option'] = BoxFederation::whereIn('id', $arr_federation)
//                ->pluck('name', 'id')->all();

            if (empty($table['federation']['option'])) {
                $table['federation']['option'] = BoxFederation::pluck('name', 'id')->all();
            }
            $linking_trainer = CategoryTrainer::find($model->trainer);

            $arr_federation = [];

            $old_id = $linking_trainer ? $linking_trainer->federation : null;

            if ($old_id) {
                $arr_federation[$old_id] = $old_id;
            }

            $max = 0;
            $linking_federation = null; // Инициализируем переменную
            while ($max < BoxFederation::count() - 1) {
                $linking_federation = BoxFederation::where('id', $old_id)
                    ->whereNotIn('id', $arr_federation)
                    ->first();

                if ($linking_federation) {
                    $old_id = $linking_federation->federation;
                    $arr_federation[$old_id] = $old_id;
                } else {
                    break;
                }

                $max++;
            }
            $table['federation']['option'] = BoxFederation::whereIn('id', $arr_federation)
                ->pluck('name', 'id')->all();

            if (empty($table['federation']['option'])) {
                $table['federation']['option'] = BoxFederation::pluck('name', 'id')->all();
            }
        }


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
                                $table['gender'],
                                $table['birthday'],

                                $table['weight'],
                                $table['arm_height'],
                                $table['height'],
                                $table['weight_category'],


                                $table['federation'],
                                $table['trainer'],
                                $table['sports_institutions'],
                                $table['achievements'],
                                $table['rank'],

                            ],
                        ],
                        [
                            'title' => 'Місце народження',
                            'type' => 'table',
                            'data' => [
                                $table['address_birth'],
                            ],
                        ],
                        [
                            'title' => 'Адреса проживання',
                            'type' => 'table',
                            'data' => [
                                $table['city'],
                                $table['street'],
                                $table['house_number'],
                                $table['apartment_number'],

                            ],
                        ],
                        [
                            'title' => 'Паспорт український',
                            'type' => 'passport',
                            'data' => $table['passport'],
                        ],
                        [
                            'title' => 'Паспорт закордонний',
                            'type' => 'passport',
                            'class' => 'fool',
                            'data' => $table['foreign_passport']
                        ],
                        $table['family']
                    ],
            ]
        ];
    }

    private function passport_edit($seria, $number)
    {
        return json_encode([
            'seria' => strtoupper($seria),
            'number' => $number,
        ]);
    }

    public function edit($id, $request, $type): array
    {
        $category = self::validate_category($request, $this->table_model, $id);
        $family_arr = [];
        foreach ($request->input('family') ?? [] as $item) {
            $family_arr[] = json_decode($item, true);
        }

        $category->birthday = $request->input('birthday');
        $category->gender = $request->input('gender');
        $category->weight = $request->input('weight');
        $category->arm_height = $request->input('arm_height');
        $category->height = $request->input('height');
        $category->weight_category = $request->input('weight_category');
        $category->federation = $request->input('federation');
        $category->trainer = $request->input('trainer');
        $category->sports_institutions = $request->input('sports_institutions');
        $category->achievements = $request->input('achievements');
        $category->rank = $request->input('rank');
        $category->address_birth = $request->input('address_birth');
        $category->passport = $this->passport_edit($request->input('passport_seria'), $request->input('passport_number'));
        $category->foreign_passport = $this->passport_edit($request->input('foreign_passport_seria'), $request->input('foreign_passport_number'));
        $category->family = json_encode($family_arr);

        $category->save();


        return [
            'error' => null,
            'data' => $category
        ];
    }

    private function get_value($table, $category_data): array
    {
        $new_data = $table;


        foreach (json_decode($category_data->family, true) as $link) {

            $new_data['family']['data'][] = [
                'name' => $link['name'] ?? '',
                'status' => $link['status'] ?? '',
                'phone' => $link['phone'] ?? '',
                'value' => json_encode($link),
            ];
        }

        $this->getDefaultValue($new_data, $category_data, $this->is_default_length);

        $this->GetValueInputs($category_data->sports_institutions, 'sports_institutions', $new_data);
        $this->GetValueInputs($category_data->federation, 'federation', $new_data);
        $this->GetValueInputs($category_data->birthday, 'birthday', $new_data);
        $this->GetValueInputs($category_data->gender, 'gender', $new_data);
        $this->GetValueInputs($category_data->arm_height, 'arm_height', $new_data);
        $this->GetValueInputs($category_data->weight, 'weight', $new_data);
        $this->GetValueInputs($category_data->height, 'height', $new_data);
        $this->GetValueInputs($category_data->weight_category, 'weight_category', $new_data);
        $this->GetValueInputs($category_data->address_birth, 'address_birth', $new_data);
        $this->GetValueInputs($category_data->passport, 'passport', $new_data);
        $this->GetValueInputs($category_data->foreign_passport, 'foreign_passport', $new_data);
        $this->GetValueInputs($category_data->trainer, 'trainer', $new_data);
        $this->GetValueInputs($category_data->achievements, 'achievements', $new_data);
        $this->GetValueInputs($category_data->sports_institutions, 'sports_institutions', $new_data);
        $this->GetValueInputs($category_data->rank, 'rank', $new_data);
        return $new_data;
    }

    private function created_view($table, $id, $model): array
    {
        return [
            [
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
                                        $table['birthday']['text'] ?? '',
                                    ], [
                                        $table['gender']['placeholder'],
                                        $table['gender']['text'] ?? '',
                                    ], [
                                        $table['weight']['placeholder'],
                                        $table['weight']['text'] ?? '',
                                    ], [
                                        $table['height']['placeholder'],
                                        $table['height']['text'] ?? '',
                                    ], [
                                        $table['weight_category']['placeholder'],
                                        $table['weight_category']['text'] ?? '',
                                    ], [
                                        $table['address_birth']['placeholder'],
                                        $table['address_birth']['text'] ?? '',
                                    ], [
                                        $table['address']['placeholder'],
                                        $table['address']['text'] ?? '',
                                    ], [
                                        $table['passport']['placeholder'],
                                        $table['passport']['value'] ?? '',
                                    ], [
                                        $table['foreign_passport']['placeholder'],
                                        $table['foreign_passport']['value'] ?? '',
                                    ],
                                    [
                                        $table['federation']['placeholder'],
                                        $table['federation']['text'] ?? '',
                                    ], [
                                        $table['trainer']['placeholder'],
                                        $table['trainer']['text'] ?? '',
                                    ], [
                                        $table['sports_institutions']['placeholder'],
                                        $table['sports_institutions']['text'] ?? '',
                                    ], [
                                        $table['achievements']['placeholder'],
                                        $table['achievements']['text'] ?? '',
                                    ], [
                                        $table['rank']['placeholder'],
                                        $table['rank']['text'] ?? '',
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
                        'class' => 'no-width no-wrap family',
                        'data' => [
                            'thead' => ['ПІП', 'Статус', 'Телефон'],
                            'body' =>
                                json_decode($model->family, true)

                            ,
                        ],
                    ],
                ],
            ],
//                [
//                'title' => 'Історія медичних допусків',
//                'data_wrapper' => [
//                    [
//                        'type' => 'table',
//                        'class' => 'no-width history-work no-wrap',
//                        'data' => [
//                            'thead' => ['ПІП', 'Статус', '', 'Телефон'],
//                            'body' => [
//                                [
//                                    'Кравчук Віталій Вікторович',
//                                    'Тато',
//                                    '-',
//                                    '097 777-77-77',
//                                ]
//                            ],
//                        ],
//                    ],
//                ],
//            ],
//                [
//                'title' => 'Історія страхових полісів',
//                'data_wrapper' => [
//                    [
//                        'type' => 'table',
//                        'class' => 'no-width history-work no-wrap',
//                        'data' => [
//                            'thead' => ['ПІП', 'Статус', '', 'Телефон'],
//                            'body' => [
//                                [
//                                    'Кравчук Віталій Вікторович',
//                                    'Тато',
//                                    '-',
//                                    '097 777-77-77',
//                                ]
//                            ],
//                        ],
//                    ],
//                ],
//            ],
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
            $more_data = [
                'logo' => [
                    'link' => null,
                    'class' => 'big_img'
                ],
                'register_name' => 'Реєстрація спортсмена'
            ];
        }


        switch ($type) {
            case 'register':
                $create = $this->data;
                break;
            case 'register_page':
                $create = $this->get_edit($table, null, $category);
                break;
            case 'edit_page':
                $create = $this->get_edit($table, $data['id'], $category);
                break;
            case 'edit':
                $create = $this->edit($data['id'], $request, $type);
                break;
            case "preview" :
                $create = $this->created_view($table, $data['id'], $category);
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
