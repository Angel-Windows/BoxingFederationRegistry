<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $card_data = [
            [
                'name' => 'Федерації боксу',
                'text' => 'Тут ви знайдете інформацію по всіх існуючих в Україні федераціях боксу та їх працівниках',
                'count' => '375 федерацій',
                'link' => 'federation',
                'logo' => 'img/homeAbout/box.svg'
            ], [
                'name' => 'Спортсмени',
                'text' => 'Ви можете переглядати інформацію по всіх спортсменах, їх контакти та інші данні',
                'count' => '375 спортсменів',
                'link' => 'sportsmen',
                'logo' => 'img/homeAbout/sportsmen.svg'
            ], [
                'name' => 'Тренери',
                'text' => 'Ви можете переглядати інформацію про всіх тренерів, кого вони тренують, заклад в якому працюють та їх контакти',
                'count' => '375 спортсменів',
                'link' => 'trainer',
                'logo' => 'img/homeAbout/trainer.svg'
            ], [
                'name' => 'Суддя',
                'text' => 'Ви можете переглядати інформацію про всіх суддів, їх контакти та інші данні',
                'count' => '375 спортсменів',
                'link' => 'referee',
                'logo' => 'img/homeAbout/referee.svg'
            ], [
                'name' => 'Спортивні заклади',
                'text' => 'Ви можете переглядати інформацію про всіх суддів, їх контакти та інші данні',
                'count' => '375 спортсменів',
                'link' => 'sports_grounds',
                'logo' => 'img/homeAbout/sports_grounds.svg'
            ], [
                'name' => 'Страхові компанії',
                'text' => 'Ви можете переглянути інформацію про страхові компанії, які є партнерами Федерації боксу України',
                'count' => '375 спортсменів',
                'link' => 'insurance_companies',
                'logo' => 'img/homeAbout/insurance_companies.svg'
            ], [
                'name' => 'Медичні заклади',
                'text' => 'Ви можете переглянути інформацію про медичні заклади, які є партнерами Федерації боксу України',
                'count' => '375 спортсменів',
                'link' => 'medical_institutions',
                'logo' => 'img/homeAbout/medical_institutions.svg'
            ], [
                'name' => 'Навчальні заклади',
                'text' => 'Ви можете переглянути інформацію про навчальні заклади, які є партнерами Федерації боксу України',
                'count' => '375 спортсменів',
                'link' => 'schools',
                'logo' => 'img/homeAbout/schools.svg'
            ], [
                'name' => 'Магазин/Аукціон',
                'text' => "Тут ви можете придбати речі, що прямо пов'язані з боксом, або прийняти участь в аукціоні",
                'count' => '375 спортсменів',
                'link' => 'auction',
                'logo' => 'img/homeAbout/auction.svg'
            ], [
                'name' => 'ФанЗона',
                'text' => "Тут ви можете знайти інформацію про фанів боксу та боксерів, а при реєстрації отримувати знижки на турніри, білети і різноманітні товари",
                'count' => '375 спортсменів',
                'link' => 'fan_zone',
                'logo' => 'img/homeAbout/fan_zone.svg'
            ]
        ];
        return view('page.home', compact('card_data'));
    }
}
