<?php

namespace App\Repositories\Category;

use App\Http\Controllers\Page\TrainerController;
use App\Models\Category\CategorySchool;
use App\Models\Category\CategorySportsInstitutions;
use App\Models\Category\CategorySportsman;
use App\Models\Category\CategoryTrainer;
use App\Models\Class\BoxFederation;
use App\Models\Class\ClassType;
use App\Models\Linking\LinkingMembers;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Traits\CategoryUITrait;
use App\Traits\DataTypeTrait;
use Carbon\Carbon;

/**
 * @property null $category_type_id
 */
class CategoryTrainerRepository implements CategoryRepositoryInterface
{
    use DataTypeTrait;
    use CategoryUITrait;

    private $is_default_length = 'fool';
    public $table_model = CategoryTrainer::class;
    private $data;

    public function __construct()
    {
        $this->category_type_id = ClassType::getIdCategory('category_sports_institutions');
        $this->data = $this->getDefaultArrayData($this->is_default_length, $this->data_inputs);
    }

    private $data_inputs = [
        'sportsmen' => [
            'type' => 'checkbox-list',
            'checkbox_type' => 'revert',
            'title' => 'Спортсмени',
        ],
        'history_works' => [
            'button' => 'add_history',
        ]
    ];

    private function get_edit($table, $id): array
    {

        $sportsman = CategorySportsman::where('trainer', $id)
            ->get();
        $table['federation']['option'] = BoxFederation::pluck('name', 'id');


        $table['sportsmen']['data'] = [];


//        dd($table['history_works']);


        foreach ($sportsman as $sportsman_item) {
            $table['sportsmen']['data'][] = [
                'text' => $sportsman_item->name,
                'value' => $sportsman_item->id,
            ];
        }
        if (!$id) {
            $table['sportsmen'] = null;
            $table['history_works'] = null;
        }
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
                                $table['street'],
                                $table['house_number'],
                                $table['apartment_number'],
                                $table['federation'],
                                $table['rank'],
                                $table['gov'],
                            ],
                        ],
                        $table['sportsmen'],
                        $table['history_works'],
                    ],
            ],
        ];
    }

    public function edit($id, $request, $type): array
    {
        if ($links = LinkingMembers::whereIn('id', $request->input('history_works') ?? [])->get()) {
            $update_null = [];
            $update_now = [];
            foreach ($links as $link) {
                if ($link->date_end_at === null) {
                    $update_now[] = $link->id;
                } else {
                    $update_null[] = $link->id;
                }
            }
        }

        if ($sportsmen = $request->input('sportsmen')){
            CategorySportsman::whereIn('id', $sportsmen)->update(['trainer'=>null]);
        }

        LinkingMembers::whereIn('id', $update_null)->update(['date_end_at' => null]);
        LinkingMembers::whereIn('id', $update_now)->update(['date_end_at' => Carbon::now()]);


        $category = self::validate_category($request, $this->table_model, $id);

        $category->qualification = $request->input('qualification');
        $category->federation = $request->input('federation');
        $category->rank = $request->input('rank');
        $category->gov = $request->input('gov');
        $category->save();


        return [
            'error' => null,
            'data'=>$category
        ];
    }

    private function get_value($table, $category_data): array
    {
        $new_data = $table;


        $linking = LinkingMembers::leftJoin('category_sports_institutions', 'category_sports_institutions.id', 'linking_members.category_id')
            ->where('category_type', ClassType::getIdCategory('category_sports_institutions'))
            ->where('member_id', $category_data->id)
            ->select(
                'linking_members.*',
                'category_sports_institutions.name as category_sports_institutions_name',
                'linking_members.id as linking_members_id',
            )
            ->get();
        foreach ($linking as $link) {
            $new_data['history_works']['data'][] = [
                'name' => $link->category_sports_institutions_name,
                'start_work' => ($link->date_start_at),
                'end_work' => $link->date_end_at,
                'value' => $link->linking_members_id,
            ];
        }

        $this->getDefaultValue($new_data, $category_data, $this->is_default_length);
        $this->GetValueInputs($category_data->qualification, 'qualification', $new_data);
        $this->GetValueInputs($category_data->school, 'school', $new_data);
        $this->GetValueInputs($category_data->rank, 'rank', $new_data);
//        $this->GetValueInputs($category_data->sportsmen, 'sportsmen', $new_data);
        $this->GetValueInputs($category_data->federation, 'federation', $new_data);

        $new_data['sportsmen']['data'] = CategorySportsman::where('trainer', $category_data->id)->pluck('name', 'id')->toArray();
        $new_data['gov']['value'] = $category_data->gov ?? "";

        return $new_data;
    }

    private function created_view($table, $id): array
    {
        foreach ($table['history_works']['data'] as $item) {
            $table['history_works']['data_view'][] = [
                $item['name'],
                $item['start_work'],
                '-',
                $item['end_work'],
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
                                    $table['qualification']['placeholder'],
                                    $table['qualification']['text'] ?? '',
                                ], [
                                    $table['federation']['placeholder'],
                                    $table['federation']['text'] ?? '',
                                ], [
                                    $table['address']['placeholder'],
                                    $table['address']['text'] ?? '',
                                ], [
                                    $table['city']['placeholder'],
                                    $table['city']['text'] ?? '',
                                ], [
                                    $table['rank']['placeholder'],
                                    $table['rank']['text'] ?? '',
                                ], [
                                    $table['gov']['placeholder'],
                                    $table['gov']['text'] ?? '',
                                ], [
                                    $table['school']['placeholder'],
                                    $table['school']['text'] ?? '',
                                ], [
                                    $table['sportsmen']['placeholder'],
                                    implode(', ', $table['sportsmen']['data']),
                                ],
                            ],
                        ],
                    ],
                ],
            ], [
                'title' => 'Історія місць роботи',
                'class' => ' fool',
                'data_wrapper' => [
                    [
                        'type' => 'table',
                        'class' => 'history-work no-wrap',
                        'data' => [
                            'thead' => ['Назва закладу', 'Початок', '', 'Кінець'],

                            'body' =>
                                $table['history_works']['data_view']
//                                [
//                                    $table['qualification']['placeholder'],
//                                    $table['qualification']['value'] ?? '',
//                                    '',
//                                    $table['qualification']['value'] ?? '',
//                                ]

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
            'more_data' => $more_data,
        ];
    }
}
