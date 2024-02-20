<?php

namespace Database\Seeders;

use App\Models\Class\ClassType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        ClassType::truncate();
        ClassType::insert([[
                'name' => 'Федерації боксу',
                'genitive' => 'федерації боксу',
                'dative' => 'Федерацій боксу',
                'accusative' => 'федерацію боксу',
                'description' => 'Тут ви знайдете інформацію про всі існуючі в Україні федерації боксу та їх працівників',
                'count' => 375,
                'linking' => null,
                'link' => 'box_federations',
//                'route ' => 'federation',
                'logo' => 'img/homeAbout/box.svg',
            ], [
                'name' => 'Спортсмени',
                'genitive' => 'Спортсменів',
                'dative' => 'спортсмену',
                'accusative' => 'sss',
                'description' => 'Ви можете переглядати інформацію про всіх спортсменів, їх контакти та інші данні',
                'linking' => null,
                'count' => 11,
                'link' => 'category_sportsmen',
                'logo' => 'img/homeAbout/sportsmen.svg'
            ], [
                'name' => 'Тренери',
                'genitive' => 'Тренерів',
                'dative' => 'тренера',
                'accusative' => 'sss',
                'description' => 'Ви можете переглядати інформацію про всіх тренерів, кого вони тренують, заклад в якому працюють та їх контакти',
                'linking' => null,
                'count' => 33,
                'link' => 'category_trainers',
                'logo' => 'img/homeAbout/trainer.svg'
            ], [
                'name' => 'Судді',
                'genitive' => 'Суддів',
                'dative' => 'судді',
                'accusative' => 'sss',
                'description' => 'Ви можете переглядати інформацію про всіх суддів, їх контакти та інші данні',
                'linking' => null,
                'count' => 112,
                'link' => 'category_judges',
                'logo' => 'img/homeAbout/referee.svg'
            ], [
                'name' => 'Спортивні заклади',
                'genitive' => 'Спортивних закладів',
                'dative' => 'спортивного закладу',
                'accusative' => 'sss',
                'description' => 'Ви можете переглядати інформацію про всі спортивні заклади, їх контакти та інші данні',
                'linking' => json_encode(['category_trainers', 'category_judges']),
                'count' => 123,
                'link' => 'category_sports_institutions',
                'logo' => 'img/homeAbout/sports_grounds.svg'
            ], [
                'name' => 'Страхові компанії',
                'genitive' => 'Страхових компаній',
                'dative' => 'страхової компанії',
                'accusative' => 'sss',
                'description' => 'Ви можете переглянути інформацію про страхові компанії, які є партнерами Федерації боксу України',
                'linking' => null,
                'count' => 44,
                'link' => 'category_insurances',
                'logo' => 'img/homeAbout/insurance_companies.svg'
            ], [
                'name' => 'Медичні заклади',
                'genitive' => 'Медичних закладів',
                'dative' => 'медичного закладу',
                'accusative' => 'sss',
                'description' => 'Ви можете переглянути інформацію про медичні заклади, які є партнерами Федерації боксу України',
                'linking' => null,
                'count' => 8,
                'link' => 'category_medicals',
                'logo' => 'img/homeAbout/medical_institutions.svg'
            ], [
                'name' => 'Навчальні заклади',
                'genitive' => 'Навчальних закладів',
                'dative' => 'навчального закладу',
                'accusative' => 'sss',
                'description' => 'Ви можете переглянути інформацію про навчальні заклади, які є партнерами Федерації боксу України',
                'linking' => null,
                'count' => 119,
                'link' => 'category_schools',
                'logo' => 'img/homeAbout/schools.svg'
            ], [
                'name' => 'Магазин/Аукціон',
                'genitive' => 'Магазинів/Аукціонів',
                'dative' => 'магазину / аукціону',
                'accusative' => 'sss',
                'description' => "Тут ви можете придбати речі, що прямо пов'язані з боксом, або прийняти участь в аукціоні",
                'linking' => null,
                'count' => 445,
                'link' => 'category_stores',
                'logo' => 'img/homeAbout/auction.svg'
            ], [
                'name' => 'ФанЗона',
                'genitive' => 'Фанів',
                'dative' => 'фанЗони',
                'accusative' => 'sss',
                'description' => "Тут ви можете зареєструватись як фан боксу та отримувати знижки та інші заохочення від Федерації боксу України",
                'linking' => null,
                'count' => 13,
                'link' => 'category_fun_zones',
                'logo' => 'img/homeAbout/fan_zone.svg'
            ],
//                Працівники
                [
                    'name' => 'Працівник федерації',
                    'genitive' => 'Працівники закладу',
                    'dative' => 'Працівники закладу',
                    'accusative' => 'Працівника закладу',
                    'description' => null,
                    'linking' => null,
                    'count' => 13,
                    'link' => 'employees_federation',
                    'logo' => null
                ],
                [
                    'name' => 'Працівник спортивного закладу',
                    'genitive' => 'Працівники закладу',
                    'dative' => 'Працівники закладу',
                    'accusative' => 'Працівника закладу',
                    'description' => null,
                    'linking' => null,
                    'count' => 13,
                    'link' => 'employees_sports_institution',
                    'logo' => null
                ],
                [
                    'name' => 'Працівник страхові компанії',
                    'genitive' => 'Працівники закладу',
                    'dative' => 'Працівники закладу',
                    'accusative' => 'Працівника закладу',
                    'description' => null,
                    'linking' => null,
                    'count' => 13,
                    'link' => 'employees_insurances',
                    'logo' => null
                ],
                [
                    'name' => 'Працівник медичного закладу',
                    'genitive' => 'Працівники закладу',
                    'dative' => 'Працівники закладу',
                    'accusative' => 'Працівника закладу',
                    'description' => null,
                    'linking' => null,
                    'count' => 13,
                    'link' => 'employees_medical',
                    'logo' => null
                ],
                [
                    'name' => 'Працівник навчального закладу',
                    'genitive' => 'Працівники закладу',
                    'dative' => 'Працівники закладу',
                    'accusative' => 'Працівника закладу',
                    'description' => null,
                    'linking' => null,
                    'count' => 13,
                    'link' => 'employees_school',
                    'logo' => null
                ],
            ]
        );
    }
}
