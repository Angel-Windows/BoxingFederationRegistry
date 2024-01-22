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
                'accusative' => 'федерацію боксу',
                'description' => 'Тут ви знайдете інформацію по всіх існуючих в Україні федераціях боксу та їх працівниках',
                'count' => 375,
                'link' => 'federation',
                'logo' => 'img/homeAbout/box.svg',
            ], [
                'name' => 'Спортсмени',
                'genitive' => 'спортсмену',
                'accusative' => 'sss',
                'description' => 'Ви можете переглядати інформацію по всіх спортсменах, їх контакти та інші данні',
                'count' => 11,
                'link' => 'sportsmen',
                'logo' => 'img/homeAbout/sportsmen.svg'
            ], [
                'name' => 'Тренери',
                'genitive' => 'тренера',
                'accusative' => 'sss',
                'description' => 'Ви можете переглядати інформацію про всіх тренерів, кого вони тренують, заклад в якому працюють та їх контакти',
                'count' => 33,
                'link' => 'trainer',
                'logo' => 'img/homeAbout/trainer.svg'
            ], [
                'name' => 'Судді',
                'genitive' => 'судді',
                'accusative' => 'sss',
                'description' => 'Ви можете переглядати інформацію про всіх суддів, їх контакти та інші данні',
                'count' => 112,
                'link' => 'referee',
                'logo' => 'img/homeAbout/referee.svg'
            ], [
                'name' => 'Спортивні заклади',
                'genitive' => 'спортивного закладу',
                'accusative' => 'sss',
                'description' => 'Ви можете переглядати інформацію про всіх суддів, їх контакти та інші данні',
                'count' => 123,
                'link' => 'sports_grounds',
                'logo' => 'img/homeAbout/sports_grounds.svg'
            ], [
                'name' => 'Страхові компанії',
                'genitive' => 'страхової компанії',
                'accusative' => 'sss',
                'description' => 'Ви можете переглянути інформацію про страхові компанії, які є партнерами Федерації боксу України',
                'count' => 44,
                'link' => 'insurance_companies',
                'logo' => 'img/homeAbout/insurance_companies.svg'
            ], [
                'name' => 'Медичні заклади',
                'genitive' => 'медичного закладу',
                'accusative' => 'sss',
                'description' => 'Ви можете переглянути інформацію про медичні заклади, які є партнерами Федерації боксу України',
                'count' => 8,
                'link' => 'medical_institutions',
                'logo' => 'img/homeAbout/medical_institutions.svg'
            ], [
                'name' => 'Навчальні заклади',
                'genitive' => 'навчального закладу',
                'accusative' => 'sss',
                'description' => 'Ви можете переглянути інформацію про навчальні заклади, які є партнерами Федерації боксу України',
                'count' => 119,
                'link' => 'schools',
                'logo' => 'img/homeAbout/schools.svg'
            ], [
                'name' => 'Магазин/Аукціон',
                'genitive' => 'магазину / аукціону',
                'accusative' => 'sss',
                'description' => "Тут ви можете придбати речі, що прямо пов'язані з боксом, або прийняти участь в аукціоні",
                'count' => 445,
                'link' => 'auction',
                'logo' => 'img/homeAbout/auction.svg'
            ], [
                'name' => 'ФанЗона',
                'genitive' => 'фанЗони',
                'accusative' => 'sss',
                'description' => "Тут ви можете знайти інформацію про фанів боксу та боксерів, а при реєстрації отримувати знижки на турніри, білети і різноманітні товари",
                'count' => 13,
                'link' => 'fan_zone',
                'logo' => 'img/homeAbout/fan_zone.svg'
            ]]
        );
    }
}