<?php

namespace App\Repositories\Category;

use App\Models\Category\CategoryInsurance;
use App\Models\Category\CategoryMedical;
use App\Models\Category\CategorySchool;
use App\Models\Category\CategoryTrainer;
use App\Models\Class\ClassType;
use App\Repositories\Interfaces\CategoryInstitutionsRepositoryInterface;
use App\Traits\CategoryUITrait;
use App\Traits\DataTypeTrait;


class CategoryInstitutionsRepository implements CategoryInstitutionsRepositoryInterface
{
    use DataTypeTrait;
    use CategoryUITrait;
    private $is_default_length = 'fool';
    private $data = [
        'director' => [
            'name' => 'director',
            'tag' => 'input',
            'placeholder' => 'Кваліфікація',
            'option' => [
            ],
        ],
    ];

     public $table_model = CategoryInsurance::class;

    public function __construct(){
        $this->category_type_id = ClassType::getIdCategory('category_sports_institutions');
        $this->data = $this->getDefaultArrayData($this->is_default_length, $this->data_inputs);
    }
    private $data_inputs = [

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
                                $table['qualification'],
                                $table['city'],
                                $table['address'],
                                $table['house_number'],
                                $table['apartment_number'],
                                $table['rank'],
                                $table['gov'],
                            ],
                        ],
                    ],
            ],
        ];
    }

    public function edit($id, $request, $type): array
    {

        $category = self::validate_category($request, $this->table_model, $id);

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

        $this->GetValueInputs($category_data->director, 'director', $new_data);


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
                                    $table['director']['placeholder'],
                                    $table['director']['text'] ?? '',
                                ],
                                [
                                    $table['address']['placeholder'],
                                    $table['address']['text'] ?? '',
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        ];
    }

    public function get_data($data, $db_name): array
    {
        $type = $data['type'] ?? '';
        switch ($db_name) {
            case 'insurance':
                $category = CategoryInsurance::find($data['id']);
                break;
            case 'medical':
                $category = CategoryMedical::find($data['id']);
                break;
            case 'school':
                $category = CategorySchool::find($data['id']);
                break;
        }

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
