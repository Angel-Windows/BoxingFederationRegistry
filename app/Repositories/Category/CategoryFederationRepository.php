<?php
namespace App\Repositories\Category;
use App\Models\Class\BoxFederation;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Traits\CategoryUITrait;

class CategoryFederationRepository implements CategoryRepositoryInterface
{
    use CategoryUITrait;
    public function index($id): array
    {
        $category_data = BoxFederation::find($id);
        return [
            'name' => $category_data->name,
            'bottom_panel' => [
                [
                    'title' => null,
                    'data-wrapper' => [
                        'class' => '',
                        'data' => [
                            [
                                'type' => 'buttons',
                                'data' => self::getButtons(['phones' => $category_data->phones, 'emails' => $category_data->email])
                            ], [
                                'type' => 'table',
                                'data' => [
                                    'body' => [
                                        ['Президент', $category_data->director],
                                        ['Адреса федерації', $category_data->address],
                                        ['Підпорядковані федерації', $category_data->federation],
                                        ['Код за ЄДРПОУ', $category_data->edrpou],
                                        ['Вебсайт', $category_data->site],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'title' => 'Працівники федерації',
                    'data-wrapper' => [
                        'class' => 'mini',
                        'data' => [
                            [
                                'type' => 'todo_table',
                                'data' => [
                                    'thead' => ['ПІП', '', 'Посада', 'Телефон', 'Пошта'],
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
