<?php
namespace App\Repositories\Category;
use App\Models\Category\CategoryTrainer;
use App\Repositories\Interfaces\CategoryInstitutionsRepositoryInterface;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Traits\CategoryUITrait;
use Illuminate\Support\Facades\DB;

class CategoryInstitutionsRepository implements CategoryInstitutionsRepositoryInterface
{
    use CategoryUITrait;
    public function index($id, $profile_id): array
    {
        switch ($profile_id) {
            case 'insurance' :
                $table = 'category_insurances';
                $todo_text = 'Страхові агенти';
                break;
            case 'medical' :
                $table = 'category_medicals';
                $todo_text = 'Адміністратори';
                break;
            case 'school' :
                $table = 'category_schools';
                $todo_text = 'Адміністратори';
                break;
            default :
                return [];
        }
        $user = DB::table($table)->find($id);
        return [
            'name' => $user->name,
            'img' => [
                'class' => 'mini_img',
                'link' => $user->logo ?? ''
            ],
            'right_panel' => [
                [
                    'title' => null,
                    'data-wrapper' => [
                        'class' => '',
                        'data' => [
                            [
                                'type' => 'buttons',
                                'data' => self::getButtons(['phones' => $user->phones, 'emails' => $user->email])
                            ],
                            [
                                'type' => 'table',
                                'data' => [
                                    'body' => [
                                        ['Керівник', $user->director],
                                        ['Адреса', $user->address],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ], 'bottom_panel' => [
                [
                    'title' => $todo_text,
                    'data-wrapper' => [
                        'class' => 'mini',
                        'data' => [
                            [
                                'type' => 'todo_table',
                                'data' => [
                                    'thead' => ['ПІП', '', 'Місто', 'Телефон', 'Пошта'],
                                    'body' => [
                                        ['img/users_img/9284da0c7ca70f123c97200aa73fa3dc.png', 'Кравчук Віталій', 'Назва посади', '097 777-77-77', 'email@gmail.com'],
                                        ['img/users_img/9284da0c7ca70f123c97200aa73fa3dc.png', 'Пупсик Пуписиков', 'Кушать', '095-668-61-91', 'email@gmail.com'],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ]
            ]
        ];
    }
    public function edit_page(): array
    {
        return [];
    }
}
