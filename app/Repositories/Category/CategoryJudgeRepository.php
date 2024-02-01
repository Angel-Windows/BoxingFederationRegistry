<?php
namespace App\Repositories\Category;
use App\Models\Category\CategoryJudge;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Traits\CategoryUITrait;

class CategoryJudgeRepository implements CategoryRepositoryInterface
{
    use CategoryUITrait;
    public function index($id): array
    {
        $user = CategoryJudge::find($id);
        $history_medical = [];
        for ($i = 0; $i < 3; $i++) {
            $history_medical[] = [
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
                                        ['Адреса проживання', $user->address],
                                        ['Кваліфікація', $user->qualification],
                                        ['Державні, почесні звання, спортивні звання та розряди', $user->rank],
                                        ['Державні заохочення', $user->gov],
                                        ['Перелік навчальних закладів, які закінчив суддя', $user->school],
                                    ]
                                ]
                            ]
                        ]
                    ],
                ],
                [
                    'title' => 'Історія місць роботи',
                    'data-wrapper' => [
                        'class' => 'mini',
                        'data' =>
                            [
                                [
                                    'type' => 'table',
                                    'class' => 'history-work no-wrap',
                                    'data' => [
                                        'thead' => ['Назва закладу', 'Початок', '', 'Кінець'],
                                        'body' => $history_medical
                                    ]
                                ]
                            ]
                    ],
                ],
            ]
        ];
    }
    public function edit_page(): array
    {
        return [];
    }
}
