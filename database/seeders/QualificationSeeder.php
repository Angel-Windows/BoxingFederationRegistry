<?php

namespace Database\Seeders;

use App\Models\Qualification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QualificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        Qualification::query()->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Qualification::query()->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Qualification::factory()->count(10)->create();
    }
}
