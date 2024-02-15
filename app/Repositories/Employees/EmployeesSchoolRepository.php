<?php

namespace App\Repositories\Employees;

use App\Models\Category\CategorySchool;

use App\Models\Class\ClassType;
use App\Models\Employees\EmployeesSchool;
use App\Models\Linking\LinkingMembers;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Traits\CategoryUITrait;
use App\Traits\DataTypeTrait;
use DB;

class EmployeesSchoolRepository implements CategoryRepositoryInterface
{
    use DataTypeTrait;
    use CategoryUITrait;

    private $is_default_length = '';
    public $category_type_id;
    public $table_model = EmployeesSchool::class;
    public $data;

    public function __construct()
    {
        $this->category_type_id = ClassType::getIdCategory('employees_school');
        $this->data = $this->getDefaultArrayData($this->is_default_length, $this->data_inputs);
        $this->data['position']['option'] = $this->data_option['employees_school']['position'];
    }


    private $data_inputs = [
        'name' => [
            'size' => 'fool',
            'placeholder' => 'ПІП'
        ],
        'members_table' => [
            'title' => 'Працівники навчального закладу',

        ]
    ];


    private function get_edit($table, $id): array
    {
        if (!$id) {
            $table['employees'] = null;
            $table['members'] = null;
        }
        $table['school']['option'] = CategorySchool::pluck('name', 'id');
        $value = $table['school']['value'] ?? null;

        if ($id && $value) {
            $table['school']['text'] = ($table['school']['option'][$value]);
        }
        return [
            [
                'type' => '',
                'data_block' =>
                    [
                        [
                            'type' => 'table',
                            'data' => [
                                $table['school'],
                                $table['name'],
                                $table['phone'],
                                $table['email'],
                                $table['position'],
                                $table['birthday'],
                                $table['city'],
                                $table['street'],
                                $table['house_number'],
                                $table['apartment_number'],

                            ],
                        ],
                    ],
            ],
        ];
    }

    public function edit($id, $request, $type): array
    {
        $category = self::validate_category($request, $this->table_model, $id);
        $category->school_id = $request->input('school') ?? '';
        $category->position = $request->input('position') ?? null;
        $category->birthday = $request->input('birthday') ?? '';
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

        $this->GetValueInputs($category_data->position, 'position', $new_data);
        $this->GetValueInputs($category_data->school_id, 'school', $new_data);
        $this->GetValueInputs($category_data->birthday, 'birthday', $new_data);

        return $new_data;
    }

    private function created_view($table, $id): array
    {

        return [
            [
                [
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
                                        $table['birthday']['placeholder'],
                                        $table['birthday']['text'] ?? '',
                                    ], [
                                        $table['address']['placeholder'],
                                        $table['address']['value'] ?? '',
                                    ], [
                                        $table['position']['placeholder'],
                                        $table['position']['text'] ?? '',
                                    ]
                                ],
                            ],
                        ],
                    ],
                ]
            ]

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
                'register_name' => 'Реєстрація працівника школи'
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
