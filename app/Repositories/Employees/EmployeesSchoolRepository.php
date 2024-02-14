<?php

namespace App\Repositories\Employees;

use App\Models\Category\CategorySchool;
use App\Models\Category\CategorySportsInstitutions;
use App\Models\Category\CategorySportsman;
use App\Models\Category\CategoryTrainer;
use App\Models\Class\BoxFederation;
use App\Models\Class\ClassType;
use App\Models\Employees\EmployeesFederation;
use App\Models\Employees\EmployeesSchool;
use App\Models\Employees\EmployeesSportsInstitutions;
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
        ]
    ];


    private function get_edit($table, $id): array
    {
        if (!$id) {
            $table['employees'] = null;
            $table['members'] = null;
        }
        $table['school']['option'] = CategorySchool::where('id', '<>', $id)->pluck('name', 'id');

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
                                $table['city'],
                                $table['street'],
                                $table['house_number'],
                                $table['apartment_number'],
                                $table['position'],
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

        $category->school_id = $request->input('school') ?? '';
        $category->position = $request->input('position') ?? '';
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


        $employees = EmployeesFederation::where('federation_id', $category_data->id)->get();
//        dd($employees);
        foreach ($employees as $item) {
            $new_data['employees']['data'][] = [
                'logo' => [
                    'img' => $item->logo,
                    'name' => $item->name
                ],
                $item->phone,
                $item->email,
                $item->type_elem == 'trainer' ? 'Тренер' : 'Спортсмен',
                'value' => json_encode([$item->type_elem, $item->id]),
            ];
        }
        $trainers = CategoryTrainer::where('federation', $category_data->id)
            ->select(
                'id',
                'logo',
                'name',
                'email',
                'phone',
                DB::raw("'trainer' as type_elem")
            );

        $sportsman = CategorySportsman::where('federation', $category_data->id)
            ->select(
                'id',
                'logo',
                'name',
                'email',
                'phone',
                DB::raw("'sportsman' as type_elem")
            );
        $combinedResults = $trainers->union($sportsman)->get();
//        dd($combinedResults);
        foreach ($combinedResults as $combinedResult) {
            $new_data['members']['data'][] = [
                'logo' => [
                    'img' => $combinedResult->logo,
                    'name' => $combinedResult->name
                ],
                $combinedResult->phone,
                $combinedResult->email,
                $combinedResult->type_elem == 'trainer' ? 'Тренер' : 'Спортсмен',
                'value' => json_encode([$combinedResult->type_elem, $combinedResult->id]),
            ];
        }
        $this->getDefaultValue($new_data, $category_data, $this->is_default_length);

        $this->GetValueInputs($category_data->director, 'director', $new_data);
        $this->GetValueInputs($category_data->federation, 'federation', $new_data);
        $this->GetValueInputs($category_data->site, 'site', $new_data);


        return $new_data;
    }

    private function created_view($table, $id): array
    {

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
            $works[] = [$member->logo, $member->name, $member->role, $member->phone, $member->email];
        }
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
            ], [
                'title' => 'Працівники федерації',
                'data_wrapper' => [
                    [
                        'type' => 'todo_table',
                        'button_add' => '',

                        'data' => [
                            'thead' => ['ПІП', '', 'Посада', 'Телефон', 'Пошта'],
                            'body' => $works,
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
            $more_data = [
                'register_name'=>'Реєстрація працівника школи'
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
