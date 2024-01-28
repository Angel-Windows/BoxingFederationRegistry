<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\Category\CategoryTrainer;
use App\Models\Class\Trainer;
use App\Models\LinkingUsers;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use function Laravel\Prompts\select;

class TrainerController extends Controller
{
    public array $monthsUkrainian = [
        'Січень',
        'Лютий',
        'Березень',
        'Квітень',
        'Травень',
        'Червень',
        'Липень',
        'Серпень',
        'Вересень',
        'Жовтень',
        'Листопад',
        'Грудень'
    ];

    public function index(Request $request)
    {
        $user = User::where('users.id', 1)
            ->leftJoin('user_profiles', 'user_profiles.user_id', 'users.id')
            ->leftJoin('qualifications', 'qualifications.id', 'user_profiles.qualification_id')
            ->leftJoin('federations', 'federations.id', 'user_profiles.federation_id')
//            ->leftJoin('qualifications', 'qualifications.id', 'user_profiles.qualification_id')
            ->select(
                'users.email',
                'users.balance',
                'user_profiles.*',
                'qualifications.name as qualifications_name',
                'federations.name as federations_name'
            )
            ->first();
//        $linking_user = UserProfile::limit(10)->first();

        $linking_users = UserProfile::limit(15)->get()->map(function ($user) {
            return $user->fool_name;
        })->toArray();

        $monthsUkrainian = [
            'Січень',
            'Лютий',
            'Березень',
            'Квітень',
            'Травень',
            'Червень',
            'Липень',
            'Серпень',
            'Вересень',
            'Жовтень',
            'Листопад',
            'Грудень'
        ];
        $temp__checkboxes = [
            1 => 'Віталій Кравчук Вікторович',

        ];

        if ($request->has('edit')) {
            $temp__info_list = $this->edit_page();
            return view('page.trainer_edit', compact('user', 'monthsUkrainian', 'temp__checkboxes', 'temp__info_list'));
        }

        $temp__info_list = [
            'Кваліфікація' => $user->qualifications_name,
            'Моя федерація' => $user->federations_name,
            'Адреса проживання' => $user->address,
            'Державні, почесні звання, спортивні звання та розряди' => $user->rewards,
            'Державні заохочення' => $user->honors_and_awards,
            'Мої навчальні заклади' => $user->education_place,
            'Мої спортсмени' => $linking_users,
        ];
        return view('page.trainer', compact('user', 'monthsUkrainian', 'temp__checkboxes', 'temp__info_list'));

    }

    public function edit_page(): array
    {
        return [
            'last_name' => 'Прізвище',
            'first_name' => 'Імя',
            'surname' => 'По батькові',
            'phone' => 'Номер телефону',
            'email' => [
                'placeholder' => 'E-mail',
                'type' => 'email'
            ],
            'qualification' => [
                'placeholder' => 'Кваліфікація',
                'option' => [
                    'expert' => 'Експерт',
                    'trainer' => 'Тренер',
                    'kitchen' => 'Повар',
                ],
            ],
            'city' => [
                'placeholder' => 'Місто',
                'size' => 'fool',
                'option' => [
                    'zp' => 'Запоріжжя',
                    'pt' => 'Полтава',
                    'hr' => 'Херсон',
                    'vi' => 'Вінниця',
                ],
            ],
            'address' => [
                'placeholder' => 'Вулиця/провулок/проспект',
                'autocomplete' => 'street-address',
                'size' => 'fool',
                'option' => [
                    'zp' => 'Запоріжжя',
                    'pt' => 'Полтава',
                    'hr' => 'Херсон',
                    'vi' => 'Вінниця',
                ],
            ],
            'house_number' => [
                'placeholder' => 'Номер будинку',
                'option' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '4a' => '4a',
                ],
            ], 'apartment_number' => [
                'placeholder' => 'Номер квартири',
                'option' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '4a' => '4a',
                ],
            ], 'federation' => [
                'placeholder' => 'Моя федерація',
                'size' => 'fool',
                'option' => [
                    'box' => 'Бокс',
                    'school-box' => 'Школа бокса',
                    'yoga' => 'Йога',
                ],
            ], 'achievement' => [
                'placeholder' => 'Державні, почесні звання, спортивні звання та розряди',
                'size' => 'fool',
                'option' => [
                    'box' => 'Бокс',
                    'school-box' => 'Школа бокса',
                    'yoga' => 'Йога',
                ],
            ], 'state_incentives' => [
                'placeholder' => 'Державні заохочення',
                'size' => 'fool',
                'option' => [
                    'box' => 'Бокс',
                    'school-box' => 'Школа бокса',
                    'yoga' => 'Йога',
                ],
            ],
        ];
    }

    public function class_page($class_name, $id, Request $request)
    {

        if ($request->has('edit')) {
            $temp__info_list = $this->edit_page();
            return view('page.trainer_edit', compact('temp__info_list'));
        }
        $data_info = [];
        switch ($class_name) {
            case 'trainer':
                $bread_crumbs = '';
                $data_info = $this->get_trainer_data($id);
                break;
            case 'insurance-companies':
                $data_info = $this->get_insurance_companies_data();
                break;
            default :
//                return response()->view('errors.404', [], 404);
                return response()->view('errors.505', [], 404);
        }

        return view('page.trainer')
            ->with('data_info', $data_info);
    }

    private function get_trainer_data($profile_id): array
    {

        $user = CategoryTrainer::find($profile_id);
//        $user = Trainer::find($profile_id);
//        dd($user);
//        $linking_users = UserProfile::limit(15)->get()->map(function ($user) {
//            return $user->fool_name;
//        })->toArray();

        $history_work = [];


        foreach (json_decode($user->history_work) as $item) {
            $history_work[] = [
                $item->name, $this->set_month($item->start_work), '-', $this->set_month($item->end_work),
            ];
        }

        return [
            'name' => $user->name,
            'img' => [
                'class' => 'big_img',
                'link' => $user->logo
//                'link' => 'img/users_img/9284da0c7ca70f123c97200aa73fa3dc.png'
            ],
            'right_panel' => [
                [
                    'title' => null,
                    'data-wrapper' => [
                        'class' => '',
                        'data' => [
                            [
                                'type' => 'buttons',
                                'data' => $this->getButtons(['phones' => $user->phones, 'emails' => 'email@gmail.com'])
                            ],
                            [
                                'type' => 'table',
                                'data' => [
                                    'body' => [
                                        ['Кваліфікація', $user->qualification],
                                        ['Моя федерація', $user->federation],
                                        ['Адреса проживання', $user->address],
                                        ['Державні, почесні звання, спортивні звання та розряди', $user->rank],
                                        ['Державні заохочення', $user->gov],
                                        ['Мої навчальні заклади', $user->school],
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
                                        'body' => $history_work
                                    ]
                                ]
                            ]
                    ],
                ]
            ]
        ];
    }

    private function get_insurance_companies_data(): array
    {
        return [
            'name' => "insurance_companies",
            'img' => [
                'class' => 'mini_img',
                'link' => 'img/users_img/9284da0c7ca70f123c97200aa73fa3dc.png'
            ],
            'right_panel' => [
                [
                    'title' => null,
                    'data-wrapper' => [
                        'class' => '',
                        'data' => [
                            [
                                'type' => 'buttons',
                                'data' => [
                                    [
                                        'link' => '',
                                        'logo' => 'img/phone.svg',
                                        'text' => '097 777-77-77'
                                    ], [
                                        'link' => '',
                                        'logo' => 'img/mail.svg',
                                        'text' => 'email@gmail.com'
                                    ]
                                ]
                            ],
                            [
                                'type' => 'table',
                                'data' => [
                                    'body' => [
                                        ['Керівник', 'Кравчук Віталій Вікторович'],
                                        ['Адреса', 'м. Львів, Київська 34, кв. 5'],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ], 'bottom_panel' => [
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
                ], [
                    'title' => 'Спортсмени',
                    'data-wrapper' => [
                        'class' => 'mini',
                        'data' => [
                            [
                                'type' => 'todo_table',
                                'data' => [
                                    'thead' => ['ПІП', '', '', 'Телефон', 'Пошта'],
                                    'body' => [
                                        ['img/users_img/9284da0c7ca70f123c97200aa73fa3dc.png', 'Кравчук Віталій', '', '097 777-77-77', 'email@gmail.com'],
                                        ['img/users_img/9284da0c7ca70f123c97200aa73fa3dc.png', 'Пупсик Пуписиков', '', '095-668-61-91', 'email@gmail.com'],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        ];
    }

    private function getButtons(array $arr): array
    {
        $data_phones = [];

        foreach ($arr as $key => $item_category) {
            if (isJson($item_category)) {
                $items = json_decode($item_category, true); // Decode JSON as associative arrays
            } else {
                $items = [$item_category]; // Wrap non-JSON items in an array
            }

            foreach ($items as $item) {
                switch ($key) {
                    case 'phones':
                        $data_phones[] = [
                            'link' => '',
                            'logo' => 'img/phone.svg',
                            'text' => formatPhone($item),
                        ];
                        break;
                    case 'emails':
                        $data_phones[] = [
                            'link' => '',
                            'logo' => 'img/mail.svg',
                            'text' => $item,
                        ];
                        break;
                    // Add more cases if needed
                }
            }
        }
        return $data_phones;
    }


    function set_month($date)
    {
        $date_split = explode('-', $date);
        $month_index = (int)$date_split[1] - 1; // Convert month to array index
        $year = $date_split[0];

        return $this->monthsUkrainian[$month_index] . ' ' . $year;
    }
}
