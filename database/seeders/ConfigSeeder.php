<?php

namespace Database\Seeders;

use App\Models\Service\MyConfig;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MyConfig::truncate();
        MyConfig::insert([
            ['name' => 'subscription', 'group' => 'price', 'value' => '100'],
        ]);
    }
}
