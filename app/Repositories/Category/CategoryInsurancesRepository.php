<?php

namespace App\Repositories\Category;


use App\Models\Class\BoxFederation;
use App\Models\Class\ClassType;
use App\Models\Employees\EmployeesInsurance;
use App\Repositories\Interfaces\CategoryInstitutionsRepositoryInterface;
use App\Traits\CategoryUITrait;
use App\Traits\DataTypeTrait;


class CategoryInsurancesRepository implements CategoryInstitutionsRepositoryInterface
{
    use DataTypeTrait;
    use CategoryUITrait;

    private $is_default_length = '';
    public $category_type_id;
    public $table_model = BoxFederation::class;
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
            $table['employees']['data'][] = [
                $table['employees']['model']->name,
                $this->city_arr[json_decode($table['employees']['model']->address)->city],
                $table['employees']['model']->phone,
                $table['employees']['model']->email,
                'value' => $table['employees']['model']->id,

            ];
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
            EmployeesInsurance::where('insurances_id', $id)
                ->whereIn('id', $request->input('employees'))
                ->update(['insurances_id'=>null]);
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
        $new_data['employees']['model'] = EmployeesInsurance::where('insurances_id', $category_data->id)->first();

        return $new_data;
    }

    private function created_view($table, $id): array
    {


//
        $works = [];
        $employees = EmployeesInsurance::where('insurances_id', $id)->get();
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
                $this->data_option['employees_insurances']['position'][$member->position],
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
                                ], [
                                    $table['federation']['placeholder'],
                                    $table['federation']['text'] ?? '',
                                ], [
                                    $table['edrpou']['placeholder'],
                                    $table['edrpou']['text'] ?? '',
                                ], [
                                    $table['site']['placeholder'],
                                    $table['site']['text'] ?? '',
                                ],
                            ],
                        ],
                    ],
                ],
            ], $table['federation_members']
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
                'register_name' => 'Реєстрація федерації',
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
