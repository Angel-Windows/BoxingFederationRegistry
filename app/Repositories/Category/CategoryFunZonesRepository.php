<?php
namespace App\Repositories\Category;
use App\Models\Category\CategoryFunZone;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Traits\FondyTrait;

class CategoryFunZonesRepository implements CategoryRepositoryInterface
{
    use FondyTrait;
    public function index($id): array
    {
        $user = CategoryFunZone::find($id);
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
                                        ['Дата народження', $user->address],
                                        ['Місце проживання', $user->address],
                                    ]
                                ]
                            ]
                        ]
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
