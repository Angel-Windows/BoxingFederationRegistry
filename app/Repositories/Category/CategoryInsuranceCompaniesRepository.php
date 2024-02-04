<?php
namespace App\Repositories\Category;
use App\Models\Category\CategorySportsInstitutions;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Traits\FondyTrait;

class CategoryInsuranceCompaniesRepository implements CategoryRepositoryInterface
{
    use FondyTrait;
    public function index($id): array
    {
        $user = CategorySportsInstitutions::find($id);
        $users_work = [];
        for ($i = 0; $i < 3; $i++) {
            $users_work[] = [
                'Кравчук Віталій Вікторович', '02 лютого 2015', '-', '12 січня 2018',
            ];
        }
        return [
            'name' => $user->name,
            'img' => [
                'class' => 'big_img',
                'link' => $user->logo
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
                                        ['Адреса закладу', $user->address],
                                        ['Тип закладу', $user->type],
                                        ['Категорія', $user->category],
                                        ['Код за ЄДРПОУ', $user->edrpou],
                                        ['Директор', $user->director],
                                        ['Вебсайт', $user->site],
                                    ]
                                ]
                            ]
                        ]
                    ],
                ],
                [
                    'title' => 'Працівники які працюють в закладі',
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
                ],
                [
                    'title' => 'Спортсмени',
                    'data-wrapper' => [
                        'class' => 'mini',
                        'data' => [
                            [
                                'type' => 'todo_table',
                                'data' => [
                                    'thead' => ['ПІП', '', 'Телефон', 'Пошта'],
                                    'body' => [
                                        ['img/users_img/9284da0c7ca70f123c97200aa73fa3dc.png', 'Кравчук Віталій', '097 777-77-77', 'email@gmail.com'],
                                        ['img/users_img/9284da0c7ca70f123c97200aa73fa3dc.png', 'Пупсик Пуписиков', '095-668-61-91', 'email@gmail.com'],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
    public function edit_page(): array
    {
        return [];
    }
}
