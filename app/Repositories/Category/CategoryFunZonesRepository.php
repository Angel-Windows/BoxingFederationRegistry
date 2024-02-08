<?php

namespace App\Repositories\Category;

use App\Models\Category\CategoryFunZone;
use App\Models\Category\CategoryTrainer;
use App\Models\Class\ClassType;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Traits\CategoryUITrait;

/**
 * @property null $category_type_id
 */
class CategoryFunZonesRepository implements CategoryRepositoryInterface
{
    use CategoryUITrait;

    private $is_default_length = 'fool';
    public $table_model = CategoryFunZone::class;

    public function __construct()
    {
        $this->category_type_id = ClassType::getIdCategory('category_sports_institutions');
        $this->data = array_merge($this->data, $this->getDefaultArrayData($this->is_default_length));
    }

    private $data = [
        'birthday' => [
            'name' => 'email',
            'tag' => 'input',
            'placeholder' => 'Дата народження',
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
                                $table['last_name'],
                                $table['first_name'],
                                $table['surname'],
                                $table['phone'],
                                $table['email'],
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


        $category = self::validate_category($request, $this->table_model, $type, $id);

        $category->qualification = $request->input('qualification');
        $category->rank = $request->input('rank');
        $category->gov = $request->input('gov');
        $category->save();


        return [
            'error' => null
        ];
    }

    private function get_value($table, $category_data): array
    {
        $new_data = $table;

        $this->getDefaultValue($new_data, $category_data, $this->is_default_length);
        $new_data['surname']['value'] = $name[2] ?? '';
        $new_data['phone']['value'] = $category_data->phone ?? "";
        $new_data['email']['value'] = $category_data->email ?? "";
        $new_data['birthday']['value'] = $category_data->birthday ?? "";


        return $new_data;
    }

    private function created_view($table, $id): array
    {
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
                                    $table['birthday']['placeholder'],
                                    $table['birthday']['value'] ?? '',
                                ],
                                [
                                    $table['address']['placeholder'],
                                    $table['address']['value'] ?? '',
                                ],
                            ],
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
