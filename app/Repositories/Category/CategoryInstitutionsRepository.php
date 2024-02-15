<?php

namespace App\Repositories\Category;

use App\Models\Category\CategoryInsurance;
use App\Models\Category\CategoryMedical;
use App\Models\Category\CategorySchool;
use App\Models\Category\CategoryTrainer;
use App\Models\Class\ClassType;
use App\Models\Employees\EmployeesSportsInstitutions;
use App\Models\Linking\LinkingMembers;
use App\Repositories\Interfaces\CategoryInstitutionsRepositoryInterface;
use App\Traits\CategoryUITrait;
use App\Traits\DataTypeTrait;


class CategoryInstitutionsRepository implements CategoryInstitutionsRepositoryInterface
{
    use DataTypeTrait;
    use CategoryUITrait;

    private $is_default_length = 'fool';
    private $data;

    public $table_model = CategoryInsurance::class;

    public function __construct()
    {
        $this->category_type_id = ClassType::getIdCategory('category_sports_institutions');
        $this->data = $this->getDefaultArrayData($this->is_default_length, $this->data_inputs);
    }

    private $data_inputs = [
        'employees' => [
            'type' => 'table-list',
            "name" => "employees[]",
            "checkbox_type" => "revert",
            "tag" => "checkbox-list",
            "placeholder" => "Працівники федерації",
            'title' => 'Страхові агенти'
        ]
    ];

    private function get_edit($table, $id): array
    {
        foreach ($table['employees']['model'] as $employee) {
            $table['employees']['data'][] = [
                $employee->name,
                $this->city_arr[json_decode($employee->address)->city],
                $employee->phone,
                "value" => $employee->id,
            ];
        }

//        dd($table['employees']);
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
                        $table['employees'],
                    ],
            ],
        ];

//        return [
//            [
//                'type' => '',
//                'data_block' =>
//                    [
//                        [
//                            'type' => 'table',
//                            'data' => [
//
//
//
//
//
//
//
//
//
//
//
//
//                            ],
//                        ],
//                    ],
//            ],
//        ];
    }

    public function edit($id, $request, $type): array
    {
        dd($request->input());
        $category = self::validate_category($request, $this->table_model, $id);

        $category->qualification = $request->input('qualification');
        $category->rank = $request->input('rank');
        $category->gov = $request->input('gov');
        $category->save();


        return [
            'error' => null,
            'data' => $category
        ];
    }

    private function get_value($table, $category_data): array
    {


        $new_data = $table;
        $new_data['employees']['model'] = EmployeesSportsInstitutions::where('sports_institutions_id', $category_data->id)->get();
//        dd($new_data['employees']);
        $this->getDefaultValue($new_data, $category_data, $this->is_default_length);

        $this->GetValueInputs($category_data->director, 'director', $new_data);


        return $new_data;
    }

    private function created_view($table, $id): array
    {

//        $members_works = LinkingMembers::leftJoin('category_trainers', 'category_trainers.id', 'linking_members.member_id')
//            ->where('linking_members.category_id', $id)
//            ->where('linking_members.category_type', $this->category_type_id)
//            ->select(
//                'linking_members.*',
//                'category_trainers.name',
//                'category_trainers.phone',
//                'category_trainers.email',
//                'category_trainers.logo',
//            )
//            ->get();


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
            $works[] = [
                'logo' => [
                    'img' => $member->logo,
                    'name' => $member->name
                ],
                $member->name,
                $member->role,
                $member->phone,
                $member->email
            ];
        }

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
                                    $table['director']['placeholder'],
                                    $table['director']['text'] ?? '',
                                ],
                                [
                                    $table['address']['placeholder'],
                                    $table['address']['text'] ?? '',
                                ],
                            ],
                        ],
                    ],
                ],
            ]],
            [
                [
                    'title' => 'Страхові агенти',
                    'class' => 'fool',
                    'data_wrapper' => [
                        [
                            'type' => 'todo_table',
                            'button_add' => '',

                            'data' => [
                                'thead' => ['ПІП', 'Посада', 'Телефон', 'Пошта'],
                                'body' => $works,
                            ],
                        ],
                    ],
                ],
            ]
        ];
    }

    public function get_data($data, $request = null, $db_name = ''): array
    {
        $type = $data['type'] ?? '';
        switch ($db_name) {
            case 'insurance':
                $category = CategoryInsurance::find($data['id']);
                break;
            case 'medical':
                $category = CategoryMedical::find($data['id']);
                break;
            case 'school':
                $category = CategorySchool::find($data['id']);
                break;
        }

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
                'register_name' => 'Реєстрація страхової компанії'
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
