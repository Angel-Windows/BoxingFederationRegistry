<?php

namespace App\Repositories\Category;

use App\Models\Category\CategoryTrainer;
use App\Models\Class\BoxFederation;
use App\Models\Class\ClassType;
use App\Models\Federation;
use App\Models\Linking\LinkingMembers;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Services\MyAuthService;
use App\Traits\CategoryUITrait;

class CategoryFederationRepository implements CategoryRepositoryInterface
{
    use CategoryUITrait;

    private $is_default_length = '';
    public $category_type_id;
    public $table_model = BoxFederation::class;
    public function __construct(){
        $this->category_type_id = ClassType::getIdCategory('category_sports_institutions');
        $this->data = array_merge($this->data, $this->getDefaultArrayData($this->is_default_length));
    }

    public $data = [
        'director' => [
            'name' => 'director',
            'tag' => 'input',
            'placeholder' => 'Президент',
        ],
        'edrpou' => [
            'name' => 'edrpou',
            'tag' => 'input',
            'placeholder' => 'Код за ЄДРПОУ',
        ],
        'federation' => [
            'name' => 'federation',
            'tag' => 'custom-select',
            'placeholder' => 'Підпорядковані федерації',

            'option' => [
                'box' => 'Бокс',
                'school-box' => 'Школа бокса',
                'yoga' => 'Йога',
            ],
        ],
        'site' => [
            'name' => 'site',
            'tag' => 'input',
            'placeholder' => 'Вебсайт',
        ],
        'members' => [
            'name' => 'members',
            'tag' => 'custom-select',
            'size' => 'fool',
            'placeholder' => 'Учасники федерації',
            'option' => [
            ],
        ],
    ];

    private function get_edit($table, $id): array
    {
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
                                $table['members'],
                            ],
                        ],
                    ],
            ],
        ];
    }

    public function edit($id, $request, $type): array
    {
        $category = self::validate_category($request, $this->table_model, $id);

        $category->director = $request->input('director') ?? '';
        $category->federation = $request->input('federation') ?? '';
        $category->edrpou = $request->input('edrpou') ?? '';
        $category->site = $request->input('site') ?? '';
        $category->save();


        return [
            'error' => null
        ];
    }

    private function get_value($table, $category_data): array
    {
        $new_data = $table;
        $this->getDefaultValue($new_data, $category_data, $this->is_default_length);

        $new_data['director']['value'] = $category_data->director ?? "";

        $new_data['federation']['value'] = $category_data->federation ?? "";

        $new_data['edrpou']['value'] = $category_data->edrpou ?? "";
        $new_data['site']['value'] = $category_data->site ?? "";

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
                                    $table['director']['value'] ?? '',
                                ], [
                                    $table['address']['placeholder'],
                                    $table['address']['value'] ?? '',
                                ], [
                                    $table['federation']['placeholder'],
                                    $table['federation']['value'] ?? '',
                                ], [
                                    $table['edrpou']['placeholder'],
                                    $table['edrpou']['value'] ?? '',
                                ], [
                                    $table['site']['placeholder'],
                                    $table['site']['value'] ?? '',
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
