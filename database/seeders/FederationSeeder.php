<?php

namespace Database\Seeders;

use App\Models\Federation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FederationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Federation::query()->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Federation::factory()->count(10)->create();
    }
}
