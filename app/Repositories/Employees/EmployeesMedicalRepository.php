<?php

namespace App\Repositories\Employees;

use App\Models\Category\CategoryInsurance;
use App\Models\Category\CategoryMedical;
use App\Models\Category\CategorySportsInstitutions;
use App\Models\Category\CategorySportsman;
use App\Models\Category\CategoryTrainer;
use App\Models\Class\BoxFederation;
use App\Models\Class\ClassType;
use App\Models\Employees\EmployeesFederation;
use App\Models\Employees\EmployeesInsurance;
use App\Models\Employees\EmployeesMedical;
use App\Models\Employees\EmployeesSportsInstitutions;
use App\Models\Linking\LinkingMembers;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Traits\CategoryUITrait;
use App\Traits\DataTypeTrait;
use DB;

class EmployeesMedicalRepository implements CategoryRepositoryInterface
{
    use DataTypeTrait;
    use CategoryUITrait;

    private $is_default_length = '';
    public $category_type_id;
    public $table_model = EmployeesMedical::class;
    public $data;

    public function __construct()
    {
        $this->category_type_id = ClassType::getIdCategory('employees_insurances');
        $this->data = $this->getDefaultArrayData($this->is_default_length, $this->data_inputs);
        $this->data['position']['option'] = $this->data_option['employees_medical']['position'];
    }


    private $data_inputs = [
        'name' => [
            'size' => '',
            'placeholder' => 'ПІП'
        ],
        'medical' => [
            'size' => '',
            'placeholder' => 'Назва медичного закладу'
        ],
    ];


    private function get_edit($table, $id): array
    {
        if (!$id) {
            $table['employees'] = null;
            $table['members'] = null;
        }
        $table['medical']['option'] = CategoryMedical::pluck('name', 'id');
        $value = $table['medical']['value'] ?? null;
        if ($id && $value) {
            $table['medical']['text'] = $table['medical']['option'][$value];
        }
        return [
            [
                'type' => '',
                'data_block' =>
                    [
                        [
                            'type' => 'table',
                            'data' => [
                                $table['medical'],
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
        $category->medical_id = $request->input('medical') ?? null;
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

        $this->GetValueInputs($category_data->medical_id, 'medical', $new_data);
        $this->GetValueInputs($category_data->position, 'position', $new_data);
        $this->GetValueInputs($category_data->federation, 'federation', $new_data);
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
                'register_name' => 'Реєстрація працівника медичного закладу',
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
