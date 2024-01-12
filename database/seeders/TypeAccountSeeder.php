<?php

namespace Database\Seeders;

use App\Models\TypeAccount;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        TypeAccount::query()->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        TypeAccount::insert([
            ['name' => 'Тренер'],
            ['name' => 'Суддя'],
            ['name' => 'Медичний заклад'],
            ['name' => 'Страхова компанія'],
            ['name' => 'Спортивний заклад'],
            ['name' => 'Федерація'],
            ['name' => 'Навчальний заклад'],
            ['name' => 'Фан зона'],
            ['name' => 'Спортсмен'],


            ['name' => 'Працівник'],
            ['name' => 'Страховий агент'],
            ['name' => 'Адміністратор'],
            ['name' => 'Працівник федерації'],
            ['name' => 'Заклад'],
            ['name' => 'Компанія'],
        ]);

    }
}
