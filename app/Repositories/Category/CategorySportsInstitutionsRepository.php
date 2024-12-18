<?php

namespace App\Repositories\Category;

use App\Models\Category\CategorySportsInstitutions;
use App\Models\Category\CategorySportsman;
use App\Models\Category\CategoryTrainer;
use App\Models\Class\BoxFederation;
use App\Models\Class\ClassType;
use App\Models\Employees\EmployeesSportsInstitutions;
use App\Models\Linking\LinkingMembers;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Traits\CategoryUITrait;
use App\Traits\DataTypeTrait;
use Carbon\Carbon;

class CategorySportsInstitutionsRepository implements CategoryRepositoryInterface
{
    use DataTypeTrait;
    use CategoryUITrait;

    private $is_default_length = '';
    public $category_type_id;
    public $table_model = CategorySportsInstitutions::class;
    private $data;

    public function __construct()
    {
        $this->category_type_id = ClassType::getIdCategory('category_sports_institutions');
        $this->data = $this->getDefaultArrayData($this->is_default_length, $this->data_inputs);
    }

    private $data_inputs = [
        'members' => [
            'name' => 'members[]',
            'type' => 'checkbox-list',
            'checkbox_type' => 'revert',
            'size' => 'fool',
            'class' => 'fool',
            'title' => 'Працівники які працюють в закладі',
        ], 'sportsmen' => [
            'name' => 'sportsmen',
            'type' => 'checkbox-list',
            'size' => 'fool',
            'class' => 'fool',
            'checkbox_type' => 'revert',
            'title' => 'Спортсмени',
        ], 'street' => [
            'placeholder' => 'Місце знаходження',
        ],
        'trainer' => [
            'title' => "Тренери",
            'type' => 'checkbox-list',
            'size' => 'fool',
            'class' => 'fool',
            'checkbox_type' => 'revert',
        ],
        'director' => [
            'placeholder' => "Директор",
        ],
    ];


    private function get_edit($table, $id): array
    {
        $table['members']['data'] = [];
        $table['sportsmen']['data'] = [];


        if (!$id) {
            $table['sportsmen'] = null;
            $table['members'] = null;
        }
        if ($id){
            $members_works = EmployeesSportsInstitutions::where('sports_institutions_id', $id)->get();
            $trainers = LinkingMembers::leftJoin('category_trainers', 'category_trainers.id', 'linking_members.member_id')
                ->where('linking_members.category_id', $id)
                ->whereNull('linking_members.date_end_at')
                ->where('linking_members.category_type', $this->category_type_id)
                ->select(
                    'linking_members.*',
                    'category_trainers.id as category_trainers_id',
                    'category_trainers.name',
                    'category_trainers.phone',
                    'category_trainers.email',
                    'category_trainers.logo',
                )
                ->get();

            $trainers_id = $trainers->pluck('category_trainers_id')->toArray();

            $sportsman = CategorySportsman::whereIn('trainer', $trainers_id)
                ->where('sports_institutions', $id)
                ->orWhere(function ($query) use ($id) {
                    $query->where('sports_institutions', $id)
                        ->whereNull('trainer');
                })
                ->get();


            foreach ($members_works as $member) {
                $table['members']['data'][] = [
                    'text' => $member->name,
                    'subtitle' => $this->data_option['employees_sports_institutions']['position'][$member->position],
                    'value' => $member->member_id,
                ];
            }
            foreach ($sportsman as $sportsman_item) {
                $table['sportsmen']['data'][] = [
                    'text' => $sportsman_item->name,
                    'value' => $sportsman_item->id,
                ];
            }
            foreach ($trainers as $item) {
                $table['trainer']['data'][] = [
                    'text' => $item->name,
                    'subtitle' => $item->role,
                    'value' => $item->id,
                ];
            }



            $members_data = [
                'type' => 'checkbox-list',
                'class' => 'fool ',
                'checkbox_type' => 'revert',
                'data_block' =>
                    [
                        $table['members'],
                    ],
            ];
            $trainers_data = [
                'type' => 'checkbox-list',
                'class' => 'fool ',
                'checkbox_type' => 'revert',
                'data_block' =>
                    [
                        $table['trainer'],
                    ],
            ];

            $sportsman_data = [
                'type' => 'checkbox-list',
                'class' => 'fool ',
                'checkbox_type' => 'revert',
                'data_block' =>
                    [
                        $table['sportsmen'],
                    ],
            ];
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
                                $table['type'],
                                $table['phone'],
                                $table['email'],
                                $table['category'],
                                $table['edrpou'],
                                $table['director'],
                                $table['site'],
                                $table['city'],
                                $table['street'],
                                $table['house_number'],
                                $table['apartment_number'],
                            ],
                        ],

                    ],

            ],
            $members_data ?? null,
            $trainers_data ?? null,
            $sportsman_data ?? null,

        ];
    }


    public function edit($id, $request, $type): array
    {

        if ($request->has('trainer')) {
            $now = Carbon::now()->format('Y-m-d');
            LinkingMembers::where('category_id', $id)
                ->whereIn('id', $request->input('trainer'))
                ->update(['date_end_at' => $now]);
        }
        if ($request->has('members')) {
            EmployeesSportsInstitutions::where('sports_institutions_id', $id)
                ->whereIn('id', $request->input('members'))
                ->update(['sports_institutions_id' => null])
            ;
        }
        if ($request->has('sportsmen')) {

            CategorySportsman::where('sports_institutions', $id)
                ->whereIn('id', $request->input('sportsmen'))
                ->update(['sports_institutions' => null])
            ;
        }

        $members = $request->input('members') ?? [];
        $sportsmen = $request->input('sportsmen') ?? [];

        if ($members) {

        }
        if ($sportsmen) {
            CategorySportsman::whereIn('id', $sportsmen)->update(['sports_institutions' => null]);
        }


        $category = self::validate_category($request, $this->table_model, $id);

        $category->director = $request->input('director') ?? null;
        $category->edrpou = $request->input('edrpou') ?? null;
        $category->type = $request->input('type') ?? null;
        $category->site = $request->input('site') ?? null;
        $category->category = $request->input('category') ?? null;
        $category->save();


        return [
            'error' => null,
            'data' => $category
        ];
    }

    private function get_value($table, $category_data): array
    {
        $new_data = $table;


//        dd($this->get_arr_federation());
        $this->getDefaultValue($new_data, $category_data, $this->is_default_length);
        $this->GetValueInputs($category_data->category, 'category', $new_data);
        $this->GetValueInputs($category_data->type, 'type', $new_data);
        $this->GetValueInputs($category_data->edrpou, 'edrpou', $new_data);
        $this->GetValueInputs($category_data->director, 'director', $new_data);
        $this->GetValueInputs($category_data->site, 'site', $new_data);

        return $new_data;
    }

    private function created_view($table, $id): array
    {
//        $members_works = LinkingMembers::leftJoin('category_trainers', 'category_trainers.id', 'linking_members.member_id')
//            ->whereNull('linking_members.date_end_at')
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
        $trainers = LinkingMembers::leftJoin('category_trainers', 'category_trainers.id', 'linking_members.member_id')
            ->where('linking_members.category_id', $id)
            ->whereNull('linking_members.date_end_at')
            ->where('linking_members.category_type', $this->category_type_id)
            ->select(
                'linking_members.*',
                'category_trainers.id as category_trainers_id',
                'category_trainers.name',
                'category_trainers.phone',
                'category_trainers.email',
                'category_trainers.logo',
            )
            ->get();
        $trainers_id = $trainers->pluck('category_trainers_id')->toArray();
        $members_works = EmployeesSportsInstitutions::where('sports_institutions_id', $id)->get();
        $sportsman = CategorySportsman::whereIn('trainer', $trainers_id)
            ->where('sports_institutions', $id)
            ->orWhere(function ($query) use ($id) {
                $query->where('sports_institutions', $id)
                    ->whereNull('trainer');
            })
            ->get();
        foreach ($sportsman as $sportsman_item) {
            $table['sportsmen']['data'][] = [
                'logo' => [
                    'img' => $sportsman_item->logo,
                    'name' => $sportsman_item->name
                ],
                $sportsman_item->phone,
                $sportsman_item->email
            ];

        }
        $works = [];
        foreach ($members_works as $member) {
            $works[] = [
                'logo' => [
                    'img' => $member->logo,
                    'name' => $member->name
                ],
                $this->data_option['employees_sports_institutions']['position'][$member->position],
                $member->phone,
                $member->email,
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
                                    $table['address']['placeholder'],
                                    $table['address']['text'] ?? '',
                                ], [
                                    $table['type']['placeholder'],
                                    $table['type']['text'] ?? '',
                                ], [
                                    $table['category']['placeholder'],
                                    $table['category']['text'] ?? '',
                                ], [
                                    $table['edrpou']['placeholder'],
                                    $table['edrpou']['text'] ?? '',
                                ], [
                                    $table['director']['placeholder'],
                                    $table['director']['text'] ?? '',
                                ], [
                                    $table['site']['placeholder'],
                                    $table['site']['text'] ?? '',
                                ],
                            ],
                        ],
                    ],
                ],
            ]], [
                [
                    'title' => 'Працівники які працюють в закладі',
                    'class' => 'fool',
                    'data_wrapper' => [
                        [
                            'type' => 'todo_table',
                            'data' => [
                                'thead' => ['ПІП', 'Посада', 'Телефон', 'Пошта'],
                                'body' => $works,
                            ],
                        ],
                    ],
                ], [
                    'title' => 'Спортсмени',
                    'class' => 'fool',
                    'data_wrapper' => [
                        [
                            'type' => 'todo_table',
                            'data' => [
                                'thead' => ['ПІП', 'Телефон', 'Пошта'],
                                'body' => $table['sportsmen']['data'] ?? [],
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
                    'class' => 'mini_img'
                ]
            ];
            $table = $this->get_value($this->data, $category);
        } else {
            $table = $this->data;
            $more_data = [
                'register_name' => 'Реєстрація спортивного закладу',
//                'register_name' => 'Реєстрація навчального закладу',
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
