<?php

namespace App\Repositories\Category;

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

class CategoryFederationRepository implements CategoryRepositoryInterface
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
            'title' => 'Працівники федерації',
        ],
        'members' => [
            'type' => 'table-list',
//            'type' => 'checkbox-list',
            'checkbox_type' => 'revert',
            'name' => 'members[]',

            'title' => 'Члени федерації',
        ],
        'name' => [
            'size' => 'fool',
        ],
        'federation' => [
            'placeholder' => 'Підпорядковані федерації',
            'size' => '',
            'required' => true,
        ],
    ];


    private function get_edit($table, $id): array
    {
//        dd($this->data);
        if (!$id) {
            $table['employees'] = null;
            $table['members'] = null;
        }
//        dd($table['employees']);
        $table['federation']['option'] = BoxFederation::where('id', '<>', $id)->pluck('name', 'id');

        return [
            [
                'type' => '',

                'data_block' =>
                    [
                        [
                            'type' => 'table',
                            'data' => [
                                $table['name'],
                                $table['director'],
                                $table['phone'],
                                $table['email'],
                                $table['federation'],
                                $table['edrpou'],
                                $table['site'],
                                $table['city'],
                                $table['street'],
                                $table['house_number'],
                                $table['apartment_number'],
                            ],
                        ],

                        $table['employees'],
                        $table['members'],
                    ],
            ],
        ];
    }

    public function edit($id, $request, $type): array
    {
        $category = self::validate_category($request, $this->table_model, $id);
//        dd($request->input());
        $ids_employees = [];
        if ($request->employees ?? null) {
            foreach ($request->employees as $item) {
                $ids_employees[json_decode($item)[1]] = json_decode($item)[1];
            }
            EmployeesFederation::where('federation_id', $request->id)
                ->whereIn('id', $ids_employees)
                ->update(['federation_id' => null]);

        }
        $ids_members = [];
        if ($request->members ?? null) {
            foreach ($request->members as $item) {
                $ids_members[json_decode($item)[1]] = json_decode($item)[1];
            }
//            $dda = CategorySportsman::whereIn('id', $ids_members)->get();
//            dd($dda);
            CategorySportsman::whereIn('id', $ids_members)
                ->update(['federation' => null]);

        }

        $category->director = $request->input('director') ?? '';
        $category->federation = $request->input('federation') ?? '';
        $category->edrpou = $request->input('edrpou') ?? null;
        $category->site = $request->input('site') ?? '';
        $category->save();


        return [
            'error' => null,
            'data' => $category
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
            )->pluck('id', 'id');

        $sportsman = CategorySportsman::where('federation', $category_data->id)
            ->whereIn('trainer', $trainers)
            ->select(
                'id',
                'logo',
                'name',
                'email',
                'phone',
                DB::raw("'sportsman' as type_elem")
            )->get();

        foreach ($sportsman as $combinedResult) {
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
//        dd($combinedResults);
        $this->getDefaultValue($new_data, $category_data, $this->is_default_length);

        $this->GetValueInputs($category_data->director, 'director', $new_data);
        $this->GetValueInputs($category_data->federation, 'federation', $new_data);
        $this->GetValueInputs($category_data->edrpou, 'edrpou', $new_data);
        $this->GetValueInputs($category_data->site, 'site', $new_data);


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
//
        $works = [];
        $employees = EmployeesFederation::where('federation_id', $id)->get();
        foreach ($employees as $member) {
            $works[] = [
                'logo' => [
                    'img' => $member->logo,
                    'name' => $member->name,
                    'value' => $member->id,
                ],
                $member->phone,
                $member->email,
                $this->data_option['employees_federation']['position'][$member->position],
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
                'class' => 'fool',
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
                'logo' => null
            ];
            $table = $this->get_value($this->data, $category);

        } else {
            $table = $this->data;
            $more_data = [
                'register_name' => 'Реєстрація федерації'
            ];
        }
        $more_data['class'] = 'fool';


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
