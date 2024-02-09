<?php

namespace App\Repositories\Category;

use App\Models\Category\CategorySportsInstitutions;
use App\Models\Category\CategorySportsman;
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
                'Спеціалізована',
                'Олімпійська ',
                'Параолімпійська',
                'Середня загальноосвітня школа-інтернат/ліцей-інтернат спортивного профілю',
                'Училище спортивного профілю  ',
                'Спортивний ліцей',
                'Професійний коледж (коледж) спортивного профілю',
                'Фаховий коледж',

            ],
        ],
        'category' => [
            'name' => 'category',
            'tag' => 'select-box',
            'placeholder' => 'Категорія',
            'option' => [
                'Дитячо-юнацька спортивна школа',
                'Спеціалізована дитячо-юнацька спортивна школа олімпійського резерву',
                'Обласний центр олімпійської підготовки',
                'Центр олімпійської підготовки',
                'Школа вищої спортивної майстерності',
                'Спортивний клуб',

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
        $category = self::validate_category($request, $this->table_model, $id);

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
        $sportsmens_data = CategorySportsman::leftJoin('category_sports_institutions', 'category_sports_institutions.id', 'category_sportsmen.id')
//            ->whereNull('linking_members.date_end_at')
            ->where('category_sportsmen.category_sports_institutions', $id)
            ->select(
                'category_sportsmen.*',
//                'category_trainers.name',
//                'category_sportsmen.phone',
//                'category_sportsmen.email',
//                'category_sportsmen.logo',
            )
            ->get();
        $works = [];
        foreach ($members_works as $member) {
            $works[] = [$member->logo, $member->name, $member->role, $member->phone, $member->email];
        }

        $sportsmens = [];
        foreach ($sportsmens_data as $sportsmen) {
            $sportsmens[] = [$sportsmen->logo, $sportsmen->name,$sportsmen->phone, $sportsmen->email];
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
            ],[
                'title' => 'Спортсмени',
                'data_wrapper' => [
                    [
                        'type' => 'todo_table',
                        'data' => [
                            'thead' => ['ПІП','', 'Телефон', 'Пошта'],
                            'body' => $sportsmens,
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
