<?php

namespace App\Repositories\Category;

use App\Models\Category\CategoryJudge;
use App\Models\Category\CategorySportsman;
use App\Models\Category\CategoryTrainer;
use App\Models\Class\ClassType;
use App\Models\Linking\LinkingMembers;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Traits\CategoryUITrait;
use App\Traits\DataTypeTrait;
use App\Traits\FondyTrait;

class CategoryJudgeRepository implements CategoryRepositoryInterface
{
    use DataTypeTrait;
    use CategoryUITrait;
    private $is_default_length = 'fool';
    public $table_model = CategoryJudge::class;
    public function __construct(){
        $this->category_type_id = ClassType::getIdCategory('category_sports_institutions');
        $this->data = $this->getDefaultArrayData($this->is_default_length, $this->data_inputs);
    }
    private $data_inputs = [
        'history_works'=>[
            'button' => 'add_history',
        ],
        'qualification' => [
            'option' => [
                'Юний спортивний суддя',
                'Спортивний суддя другої категорії',
                'Спортивний суддя першої категорії',
                'Спортивний суддя Національної категорії',
            ],
        ],
        'rank' => [
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
    ];
    private $data;

    private function get_edit($table, $id): array
    {
        if (!$id){
            $table['history_works'] = null;
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
                                $table['qualification'],
                                $table['city'],
                                $table['address'],
                                $table['house_number'],
                                $table['apartment_number'],
                                $table['rank'],
                                $table['gov'],
                            ],
                        ],
                        $table['history_works'],
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
            'error' => null,
            'data'=>$category
        ];
    }

    private function get_value($table, $category_data): array
    {
        $new_data = $table;
        $this->getDefaultValue($new_data, $category_data, $this->is_default_length);

        $this->GetValueInputs($category_data->qualification, 'qualification', $new_data);
        $this->GetValueInputs($category_data->school, 'school', $new_data);
        $this->GetValueInputs($category_data->rank, 'rank', $new_data);
        $this->GetValueInputs($category_data->gov, 'gov', $new_data);

        $linking = LinkingMembers::leftJoin('category_sports_institutions', 'category_sports_institutions.id', 'linking_members.category_id')
            ->where('category_type', ClassType::getIdCategory('category_judges'))
            ->where('member_id', $category_data->id)
            ->select(
                'linking_members.*',
                'category_sports_institutions.name as category_sports_institutions_name',
                'category_sports_institutions.id as category_sports_institutions_id',
            )
            ->get();
        foreach ($linking as $link) {
            $new_data['history_works']['data'][] = [
                'name' => $link->category_sports_institutions_name,
                'start_work' => ($link->date_start_at),
                'end_work' => $link->date_end_at,
                'value' => $link->category_sports_institutions_id,
            ];
        }

        return $new_data;
    }

    private function created_view($table, $id): array
    {
        return [
            [[
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
                                    $table['address']['text'] ?? '',
                                ],
                                [
                                    $table['qualification']['placeholder'],
                                    $table['qualification']['text'] ?? '',
                                ], [
                                    $table['rank']['placeholder'],
                                    $table['rank']['text'] ?? '',
                                ], [
                                    $table['gov']['placeholder'],
                                    $table['gov']['text'] ?? '',
                                ], [
                                    $table['school']['placeholder'],
                                    $table['school']['text'] ?? '',
                                ],
                            ],
                        ],
                    ],
                ],
            ], [
                'title' => 'Історія місць роботи',
                'class'=>'fool',
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
            ],]
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
                'register_name'=>'Реєстрація судді'
            ];
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
