<?php

namespace Database\Seeders;

use App\Models\Category\CategoryEmployessInstitutions;
use App\Models\Category\CategoryEmployessSchool;
use App\Models\Category\CategoryFunZone;
use App\Models\Category\CategoryInsurance;
use App\Models\Category\CategoryJudge;
use App\Models\Category\CategoryMedical;
use App\Models\Category\CategorySchool;
use App\Models\Category\CategorySportsInstitutions;
use App\Models\Category\CategorySportsman;
use App\Models\Category\CategoryStore;
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
        $count_seed = 0;
        if ($count_seed > 0){
            if (!CategoryStore::exists() || false) {
                CategoryStore::truncate();
                CategoryStore::factory()->count($count_seed)->create();
            }

            if (!CategoryInsurance::exists() || false) {
                CategoryInsurance::truncate();
                CategoryInsurance::factory()->count($count_seed)->create();
            }

            if (!CategoryMedical::exists() || false) {
                CategoryMedical::truncate();
                CategoryMedical::factory()->count($count_seed)->create();
            }

            if (!CategorySchool::exists() || false) {
                CategorySchool::truncate();
                CategorySchool::factory()->count($count_seed)->create();
            }

            if (!CategoryFunZone::exists() || false) {
                CategoryFunZone::truncate();
                CategoryFunZone::factory()->count($count_seed)->create();
            }

            if (!CategorySportsInstitutions::exists() || false) {
                CategorySportsInstitutions::truncate();
                CategorySportsInstitutions::factory()->count($count_seed)->create();
            }

            if (!BoxFederation::exists() || false) {
                BoxFederation::truncate();
                BoxFederation::factory()->count($count_seed)->create();
            }

            if (!CategoryTrainer::exists() || false) {
                CategoryTrainer::truncate();
                CategoryTrainer::factory()->count($count_seed)->create();
            }

            if (!CategorySportsman::exists() || false) {
                CategorySportsman::truncate();
                CategorySportsman::factory()->count($count_seed)->create();
            }

            if (!CategoryJudge::exists() || false) {
                CategoryJudge::truncate();
                CategoryJudge::factory()->count($count_seed)->create();
            }
            //Працівники


            if (!CategoryEmployessInstitutions::exists() || false) {
                CategoryEmployessInstitutions::truncate();
                CategoryEmployessInstitutions::factory()->count($count_seed)->create();
            }

            if (!CategoryEmployessSchool::exists() || false) {
                CategoryEmployessSchool::truncate();
                CategoryEmployessSchool::factory()->count($count_seed)->create();
            }
        }

    }
}
