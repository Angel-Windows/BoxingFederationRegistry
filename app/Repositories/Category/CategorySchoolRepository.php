<?php

namespace App\Repositories\Category;

use App\Models\Category\CategorySchool;
use App\Models\Class\ClassType;
use App\Models\Employees\EmployeesSchool;
use App\Repositories\Interfaces\CategoryInstitutionsRepositoryInterface;
use App\Traits\CategoryUITrait;
use App\Traits\DataTypeTrait;


class CategorySchoolRepository implements CategoryInstitutionsRepositoryInterface
{
    use DataTypeTrait;
    use CategoryUITrait;

    private $is_default_length = '';
    public $category_type_id;
    public $table_model = CategorySchool::class;
    public $data;

    public function __construct()
    {
        $this->category_type_id = ClassType::getIdCategory('category_sports_institutions');
        $this->data = $this->getDefaultArrayData($this->is_default_length, $this->data_inputs);
    }


    private $data_inputs = [
        'employees' => [
            'type' => 'table-list',
            'name' => 'employees[]',
            'checkbox_type' => 'revert',
            'class' => 'fool',
            'size' => 'fool',
            'title' => 'Страхові агенти',
        ],
        'address' => [
            'size' => 'fool',
        ],
        'director' => [
            'placeholder' => 'Керівник',
            'size' => '',
            'required' => true,
        ],
    ];


    private function get_edit($table, $id): array
    {
        if (isset($table['employees']['model'])) {
            foreach ($table['employees']['model'] as $item) {

                $table['employees']['data'][] = [
                    $item->name,
                    $this->city_arr[json_decode($item->address)->city],
                    $item->phone,
                    $item->email,
                    'value' => $item->id,
                ];
            }
        } else {
            $table['employees'] = null;
        }
        if (!$id) {
            $table['employees'] = null;
            $table['members'] = null;
        }

        return [
            [
                'type' => '',
                'data_block' =>
                    [
                        [
                            'type' => 'table',
                            'data' => [
                                $table['name'],
                                $table['email'],
                                $table['phone'],
                                $table['director'],
                                $table['city'],
                                $table['street'],
                                $table['house_number'],
                                $table['apartment_number'],
                            ],
                        ],

                        $table['employees'],
                    ],
            ],
        ];
    }

    public function edit($id, $request, $type): array
    {
        if ($request->has('employees')) {
            $d = EmployeesSchool::where('school_id', $id)
                ->whereIn('id', $request->input('employees'))
                ->update(['school_id' => null]);
        }

        $category = self::validate_category($request, $this->table_model, $id);

        $category->director = $request->input('director') ?? '';

        $category->save();


        return [
            'error' => null,
            'data' => $category
        ];
    }

    private function get_value($table, $category_data): array
    {
        $new_data = $table;


        $this->getDefaultValue($new_data, $category_data, $this->is_default_length);

        $this->GetValueInputs($category_data->director, 'director', $new_data);
        $this->GetValueInputs($category_data->federation, 'federation', $new_data);
        $this->GetValueInputs($category_data->edrpou, 'edrpou', $new_data);
        $this->GetValueInputs($category_data->site, 'site', $new_data);
        $new_data['employees']['model'] = EmployeesSchool::where('school_id', $category_data->id)->get();

        return $new_data;
    }

    private function created_view($table, $id): array
    {


//
        $works = [];
        $employees = EmployeesSchool::where('school_id', $id)->get();

//        dd($employees);
//        dd($employees);
        foreach ($employees as $member) {
            $works[] = [
                'logo' => [
                    'img' => $member->logo,
                    'name' => $member->name,
                    'value' => $member->id,
                ],
                $member->phone,
                $member->email,
                $this->data_option['employees_school']['position'][$member->position] ?? '',
            ];
        }


        if ($works) {
            $table['federation_members']['data_wrapper'][0]['data']['body'] = $works;
        } else {
            $table['federation_members'] = null;
        }
        return [
            [[
                'title' => null,
                'class' => '',
                'size' => '',
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
                                    $table['director']['text'] ?? '',
                                ], [
                                    $table['address']['placeholder'],
                                    $table['address']['text'] ?? '',
                                ]
                            ],
                        ],
                    ],
                ],
            ], $table['federation_members']
            ]
//            [
//                'title' => 'Працівники федерації',
//                'data_wrapper' => [
//                    [
//                        'type' => 'todo_table',
//                        'button_add' => '',
//
//                        'data' => [
//                            'thead' => ['ПІП', '', 'Посада', 'Телефон', 'Пошта'],
//                            'body' => $works,
//                        ],
//                    ],
//                ],
//            ],
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
                'register_name' => 'Реєстрація спортивного закладу',
                'logo' => [
                    'link' => null,
                    'class' => 'big_img'
                ]
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
