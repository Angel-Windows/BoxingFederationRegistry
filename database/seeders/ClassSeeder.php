<?php

namespace Database\Seeders;

use App\Models\Category\CategoryEmployessInstitutions;
use App\Models\Category\CategoryFunZone;
use App\Models\Category\CategoryJudge;
use App\Models\Category\CategoryMedical;
use App\Models\Category\CategorySchool;
use App\Models\Category\CategorySportsInstitutions;
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
        CategoryMedical::truncate();
        CategoryMedical::factory()->count(10)->create();

        CategorySchool::truncate();
        CategorySchool::factory()->count(10)->create();

        CategoryFunZone::truncate();
        CategoryFunZone::factory()->count(10)->create();

        CategorySportsInstitutions::truncate();
        CategorySportsInstitutions::factory()->count(10)->create();

        BoxFederation::truncate();
        BoxFederation::factory()->count(10)->create();

        CategoryTrainer::truncate();
        CategoryTrainer::factory()->count(10)->create();

        CategorySportsman::truncate();
        CategorySportsman::factory()->count(10)->create();

        CategoryJudge::truncate();
        CategoryJudge::factory()->count(10)->create();

        //Працівники

        CategoryEmployessInstitutions::truncate();
        CategoryEmployessInstitutions::factory()->count(10)->create();
    }
}
