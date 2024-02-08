<?php

namespace App\Repositories\Category;

use App\Models\Category\CategorySportsInstitutions;
use App\Models\Category\CategoryTrainer;
use App\Models\Class\ClassType;
use App\Models\Linking\LinkingMembers;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Traits\CategoryUITrait;

class CategorySportsInstitutionsRepository implements CategoryRepositoryInterface
{
    use CategoryUITrait;
    private $is_default_length = '';
    public $category_type_id;
    private $data = [
        'type' => [
            'name' => 'type',
            'tag' => 'select-box',
            'placeholder' => 'Тип закладу',
            'option' => [
                'test',
                'temp',
            ],
        ],
        'category' => [
            'name' => 'category',
            'tag' => 'select-box',
            'placeholder' => 'Категорія',
            'option' => [
                'test',
                'temp',
            ],
        ],
        'edrpou' => [
            'name' => 'edrpou',
            'tag' => 'input',
            'placeholder' => 'Код за ЄДРПОУ',
        ],
        'director' => [
            'name' => 'director',
            'tag' => 'input',
            'placeholder' => 'Директор',
        ],
        'site' => [
            'name' => 'site',
            'tag' => 'input',
            'placeholder' => 'Веб сайт',
        ],
        'members' => [
            'name' => 'members',
            'tag' => 'checkbox-list',
            'placeholder' => 'Працівники',
        ],

    ];

     public $table_model = CategorySportsInstitutions::class;

    public function __construct(){
        $this->category_type_id = ClassType::getIdCategory('category_sports_institutions');
        $this->data = array_merge($this->data, $this->getDefaultArrayData($this->is_default_length));
    }


    private function get_edit($table, $id): array
    {
        $members_works = LinkingMembers::leftJoin('category_trainers', 'category_trainers.id', 'linking_members.member_id')
            ->where('linking_members.category_id', $id)
            ->whereNull('linking_members.date_end_at')
            ->where('linking_members.category_type', $this->category_type_id)
            ->select(
                'linking_members.*',
                'category_trainers.name',
                'category_trainers.phone',
                'category_trainers.email',
                'category_trainers.logo',
            )
            ->get();

        $table['members']['data'] = [];
        foreach ($members_works as $member) {
            $table['members']['data'][] = [
                'text' => $member->name,
                'value' => $member->member_id,
                'subtitle' => $member->id,
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
                                $table['address'],
                                $table['house_number'],
                                $table['apartment_number'],

                            ],
                        ],

                    ],
            ],
            [
                'class' => 'grid-sp-2',
                'data_block' => [
                    [
                        'title' => 'Працівники які працюють в закладі',
                        'data' => [
                            $table['members'],
                        ]]
                ],
            ]

        ];

    }

    public function edit($id, $request, $type): array
    {
        $category = self::validate_category($request, $this->table_model, $type, $id);

        $category->type = $request->input('name');
        $category->category = self::convertAddressRequest($request);
        $category->save();


        return [
            'error' => null
        ];
    }

    private function get_value($table, $category_data): array
    {
        $new_data = $table;


        $this->getDefaultValue($new_data, $category_data, $this->is_default_length);


        $new_data['category']['value'] = $category_data->category ?? "";
        $new_data['type']['value'] = $category_data->type ?? "";
        $new_data['edrpou']['value'] = $category_data->edrpou ?? "";
        $new_data['director']['value'] = $category_data->director ?? "";
        $new_data['site']['value'] = $category_data->site ?? "";


        return $new_data;
    }

    private function created_view($table, $id): array
    {
        $members_works = LinkingMembers::leftJoin('category_trainers', 'category_trainers.id', 'linking_members.member_id')
            ->whereNull('linking_members.date_end_at')
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
                    ],
                    [
                        'type' => 'table',
                        'data' => [
                            'body' => [
                                [
                                    $table['address']['placeholder'],
                                    $table['address']['value'] ?? '',
                                ], [
                                    $table['type']['placeholder'],
                                    $table['type']['value'] ?? '',
                                ], [
                                    $table['category']['placeholder'],
                                    $table['category']['value'] ?? '',
                                ], [
                                    $table['edrpou']['placeholder'],
                                    $table['edrpou']['value'] ?? '',
                                ], [
                                    $table['director']['placeholder'],
                                    $table['director']['value'] ?? '',
                                ], [
                                    $table['site']['placeholder'],
                                    $table['site']['value'] ?? '',
                                ],
                            ],
                        ],
                    ],
                ],
            ], [
                'title' => 'Працівники які працюють в закладі',
                'data_wrapper' => [
                    [
                        'type' => 'todo_table',
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
        }


        switch ($type) {
            case 'register':
                $create = $this->data;
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
            'more_data' => $more_data
        ];
    }
}
