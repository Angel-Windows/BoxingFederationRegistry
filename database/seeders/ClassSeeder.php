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
        $count_seed = 25;
        $rebase = true;
        if ($count_seed > 0) {

            if ((!CategoryTrainer::exists() && true) || $rebase) {
                dump('CategoryTrainer');
                CategoryTrainer::truncate();
                CategoryTrainer::factory()->count($count_seed)->create();
            }

            if ((!CategoryStore::exists() && true) || $rebase) {
                dump('CategoryStore');
                CategoryStore::truncate();
                CategoryStore::factory()->count($count_seed)->create();
            }

            if ((!CategoryInsurance::exists() && true) || $rebase) {
                dump('CategoryInsurance');
                CategoryInsurance::truncate();
                CategoryInsurance::factory()->count($count_seed)->create();
            }

            if ((!CategoryMedical::exists() && true) || $rebase) {
                dump('CategoryMedical');
                CategoryMedical::truncate();
                CategoryMedical::factory()->count($count_seed)->create();
            }

            if ((!CategorySchool::exists() && true) || $rebase) {
                dump('CategorySchool');
                CategorySchool::truncate();
                CategorySchool::factory()->count($count_seed)->create();
            }

            if ((!CategoryFunZone::exists() && true) || $rebase) {
                dump('CategoryFunZone');
                CategoryFunZone::truncate();
                CategoryFunZone::factory()->count($count_seed)->create();
            }

            if ((!CategorySportsInstitutions::exists() && true) || $rebase) {
                dump('CategorySportsInstitutions');
                CategorySportsInstitutions::truncate();
                CategorySportsInstitutions::factory()->count($count_seed)->create();
            }

            if ((!BoxFederation::exists() && true) || $rebase) {
                dump('BoxFederation');
                BoxFederation::truncate();
                BoxFederation::factory()->count($count_seed)->create();
            }


            if ((!CategorySportsman::exists() && true) || $rebase) {
                dump('CategorySportsman');
                CategorySportsman::truncate();
                CategorySportsman::factory()->count($count_seed)->create();
            }

            if ((!CategoryJudge::exists() && true) || $rebase) {
                dump('CategoryJudge');
                CategoryJudge::truncate();
                CategoryJudge::factory()->count($count_seed)->create();
            }
            //Працівники


            if ((!CategoryEmployessInstitutions::exists() && true) || $rebase) {
                dump('CategoryEmployessInstitutions');
                CategoryEmployessInstitutions::truncate();
                CategoryEmployessInstitutions::factory()->count($count_seed)->create();
            }

            if ((!CategoryEmployessSchool::exists() && true) || $rebase) {
                dump('CategoryEmployessSchool');
                CategoryEmployessSchool::truncate();
                CategoryEmployessSchool::factory()->count($count_seed)->create();
            }
        }

    }
}
