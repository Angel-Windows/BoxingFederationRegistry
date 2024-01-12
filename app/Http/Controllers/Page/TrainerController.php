<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use function Laravel\Prompts\select;

class TrainerController extends Controller
{
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
            4 => 'Віталій Кравчук',
            5 => 'Віталій Кравчук',
            6 => 'Сергей Сивоха',
            10 => 'Віталій Кравчук Вікторович',
            15 => 'Сергей Сивоха',
            16 => 'Віталій Кравчук Вікторович',
            20 => 'Сергей Сивоха',
            21 => 'Віталій Кравчук Вікторович',
            22 => 'Віталій Кравчук',
            23 => 'Сергей Сивоха',
        ];

        if ($request->has('edit')) {
            $temp__info_list = [
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
            return view('page.trainer_edit', compact('user','monthsUkrainian', 'temp__checkboxes', 'temp__info_list'));
        }
        $temp__info_list = [
            'Кваліфікація' => $user->qualifications_name,
            'Моя федерація' => $user->federations_name,
            'Адреса проживання' => $user->address,
            'Державні, почесні звання, спортивні звання та розряди' => 'Lorem ipsum dolor sit amet consectetur. ',
            'Державні заохочення' => 'Lorem ipsum dolor sit amet consectetur. ',
            'Мої навчальні заклади' => 'Lorem ipsum dolor sit amet consectetur. ',
            'Мої спортсмени' => 'Кравчук Віталій, Кравчук Віталій, Кравчук Віталій, Кравчук Віталій, Кравчук Віталій, Кравчук Віталій,Кравчук ВіталійКравчук ВіталійКравчук ВіталійКравчук ВіталійКравчук ВіталійКравчук ВіталійКравчук ВіталійКравчук Віталій',
        ];
        return view('page.trainer', compact('user','monthsUkrainian', 'temp__checkboxes', 'temp__info_list'));

    }
}
