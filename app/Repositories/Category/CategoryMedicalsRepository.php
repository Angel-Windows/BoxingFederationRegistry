<?php

namespace App\Repositories\Category;

use App\Models\Category\CategoryInsurance;
use App\Models\Category\CategoryMedical;
use App\Models\Category\CategorySchool;
use App\Models\Category\CategorySportsman;
use App\Models\Category\CategoryTrainer;
use App\Models\Class\BoxFederation;
use App\Models\Class\ClassType;
use App\Models\Employees\EmployeesFederation;
use App\Models\Employees\EmployeesInsurance;
use App\Models\Employees\EmployeesMedical;
use App\Models\Employees\EmployeesSportsInstitutions;
use App\Models\Linking\LinkingMembers;
use App\Repositories\Interfaces\CategoryInstitutionsRepositoryInterface;
use App\Traits\CategoryUITrait;
use App\Traits\DataTypeTrait;


class CategoryMedicalsRepository implements CategoryInstitutionsRepositoryInterface
{
    use DataTypeTrait;
    use CategoryUITrait;

    private $is_default_length = '';
    public $category_type_id;
    public $table_model = CategoryMedical::class;
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
            'title' => 'Адміністратори',
        ],
        'address' => [
            'size' => 'fool',
        ],
        'director' => [
            'placeholder' => 'Керівник',
            'size' => '',
            'required' => true,
        ],
        'members_table' => [
            'title' => 'Адміністратори',
        ]
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
//            dd($table['employees']['data']);
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
                    ],
            ],[
                'type' => '',
                'class' => 'fool',

                'data_block' =>
                    [
                        $table['employees'],
                    ],
            ],
        ];
    }

    public function edit($id, $request, $type): array
    {
        if ($request->has('employees')) {
            $d = EmployeesMedical::where('medical_id', $id)
                ->whereIn('id', $request->input('employees'))
                ->update(['medical_id' => null]);
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
        $new_data['employees']['model'] = EmployeesMedical::where('medical_id', $category_data->id)->get();

        return $new_data;
    }

    private function created_view($table, $id): array
    {
        $works = [];
        $employees = EmployeesMedical::where('medical_id', $id)->get();

        foreach ($employees as $member) {
            $works[] = [
                'logo' => [
                    'img' => $member->logo,
                    'name' => $member->name,
                ],
                $member->phone,
                $member->email,
                $this->data_option['employees_medical']['position'][$member->position] ?? '',
            ];
        }


        if ($works) {
            $table['members_table']['data_wrapper'][0]['data']['body'] = $works;
        } else {
            $table['members_table'] = null;
        }
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
                ],
            ],
            [
                $table['members_table']
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
                    'class' => 'mini_img'
                ]
            ];
            $table = $this->get_value($this->data, $category);

        } else {
            $table = $this->data;
            $more_data = [
                'register_name' => 'Реєстрація медичної компанії',
                'logo' => [
                    'link' => null,
                    'class' => 'mini_img'
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
