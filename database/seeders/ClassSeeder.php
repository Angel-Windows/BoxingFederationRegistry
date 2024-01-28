<?php

namespace Database\Seeders;

use App\Models\Category\CategoryJudge;
use App\Models\Category\CategorySportsman;
use App\Models\Category\CategoryTrainer;
use App\Models\Class\BoxFederation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BoxFederation::truncate();
        BoxFederation::factory()->count(10)->create();

        CategoryTrainer::truncate();
        CategoryTrainer::factory()->count(10)->create();

        CategorySportsman::truncate();
        CategorySportsman::factory()->count(10)->create();

        CategoryJudge::truncate();
        CategoryJudge::factory()->count(10)->create();
    }
}