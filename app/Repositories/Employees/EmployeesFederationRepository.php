<?php

namespace App\Repositories\Employees;

use App\Models\Category\CategorySportsman;
use App\Models\Category\CategoryTrainer;
use App\Models\Class\BoxFederation;
use App\Models\Class\ClassType;
use App\Models\Employees\EmployeesFederation;
use App\Models\Linking\LinkingMembers;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Traits\CategoryUITrait;
use App\Traits\DataTypeTrait;
use DB;

class EmployeesFederationRepository implements CategoryRepositoryInterface
{
    use DataTypeTrait;
    use CategoryUITrait;

    private $is_default_length = '';
    public $category_type_id;
    public $table_model = EmployeesFederation::class;
    public $data;

    public function __construct()
    {
        $this->category_type_id = ClassType::getIdCategory('category_sports_institutions');
        $this->data = $this->getDefaultArrayData($this->is_default_length, $this->data_inputs);
        $this->data['position']['option'] = $this->data_option['employees_federation']['position'];
    }


    private $data_inputs = [
        'name'=>[
            'size' => 'fool',
            'placeholder' => 'ПІП'
        ]
    ];


    private function get_edit($table, $id): array
    {
        $table['federation']['option'] = BoxFederation::pluck('name', 'id');
//        dd($table['federation']);
        return [
            [
                'type' => '',
                'data_block' =>
                    [
                        [
                            'type' => 'table',
                            'data' => [
                                $table['federation'],
                                $table['name'],
                                $table['phone'],
                                $table['city'],
                                $table['position'],
                                $table['email'],
                                $table['birthday'],
                            ],
                        ],
                    ],
            ],
        ];
    }

    public function edit($id, $request, $type): array
    {
        $category = self::validate_category($request, $this->table_model, $id);
        $category->federation_id = $request->input('federation') ?? '';
        $category->name = $request->input('name') ?? '';
        $category->phone = $request->input('phone') ?? '';
        $category->city = $request->input('city') ?? '';
        $category->position = $request->input('position') ?? null;
        $category->email = $request->input('email') ?? '';
        $category->birthday = $request->input('birthday') ?? '';
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

        $this->GetValueInputs($category_data->city, 'city', $new_data);
        $this->GetValueInputs($category_data->federation_id, 'federation', $new_data);
        $this->GetValueInputs($category_data->birthday, 'birthday', $new_data);
        $this->GetValueInputs($this->data_option['employees_federation']['position'][$category_data->position], 'position', $new_data);


        return $new_data;
    }

    private function created_view($table, $id): array
    {
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
                                    $table['federation']['placeholder'],
                                    $table['federation']['text'] ?? '',
                                ], [
                                    $table['birthday']['placeholder'],
                                    $table['birthday']['value'] ?? '',
                                ], [
                                    $table['city']['placeholder'],
                                    $table['city']['value'] ?? '',
                                ], [
                                    $table['position']['placeholder'],
                                    $table['position']['value'] ?? '',
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
                'register_name'=>'Реєстрація працівника федерації'
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
