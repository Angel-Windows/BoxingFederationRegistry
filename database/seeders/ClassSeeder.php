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
use App\Models\Employees\EmployeesFederation;
use App\Models\Employees\EmployeesInsurance;
use App\Models\Employees\EmployeesMedical;
use App\Models\Employees\EmployeesSchool;
use App\Models\Employees\EmployeesSportsInstitutions;
use Database\Factories\Employees\EmployeesFederationFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $count_seed = 100;
        $rebase = true;
        if ($count_seed > 0) {
            if ((!CategorySchool::exists() && true) || $rebase) {
                dump('CategorySchool');
                CategorySchool::truncate();
                CategorySchool::factory()->count($count_seed)->create();
            }
            if ((!CategoryMedical::exists() && true) || $rebase) {
                dump('CategoryMedical');
                CategoryMedical::truncate();
                CategoryMedical::factory()->count($count_seed)->create();
            }
            if ((!CategoryInsurance::exists() && true) || $rebase) {
                dump('CategoryInsurance');
                CategoryInsurance::truncate();
                CategoryInsurance::factory()->count($count_seed)->create();
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
            if ((!CategoryStore::exists() && true) || $rebase) {
                dump('CategoryStore');
                CategoryStore::truncate();
                CategoryStore::factory()->count($count_seed)->create();
            }


            if ((!CategoryTrainer::exists() && true) || $rebase) {
                dump('CategoryTrainer');
                CategoryTrainer::truncate();
                CategoryTrainer::factory()->count($count_seed * 2)->create();
            }
            if ((!CategorySportsman::exists() && true) || $rebase) {
                dump('CategorySportsman');
                CategorySportsman::truncate();
                CategorySportsman::factory()->count($count_seed * 2)->create();
            }
            if ((!CategoryJudge::exists() && true) || $rebase) {
                dump('CategoryJudge');
                CategoryJudge::truncate();
                CategoryJudge::factory()->count($count_seed * 2)->create();
            }


//            //Працівники




            if ((!EmployeesFederation::exists() && true) || $rebase) {
                dump('EmployeesFederation');
                EmployeesFederation::truncate();
                EmployeesFederation::factory()->count($count_seed * 3)->create();
            }
            if ((!EmployeesSportsInstitutions::exists() && true) || $rebase) {
                dump('EmployeesSportsInstitutions');
                EmployeesSportsInstitutions::truncate();
                EmployeesSportsInstitutions::factory()->count($count_seed * 3)->create();
            }
            if ((!EmployeesInsurance::exists() && true) || $rebase) {
                dump('EmployeesInsurance');
                EmployeesInsurance::truncate();
                EmployeesInsurance::factory()->count($count_seed * 3)->create();
            }
            if ((!EmployeesMedical::exists() && true) || $rebase) {
                dump('EmployeesMedical');
                EmployeesMedical::truncate();
                EmployeesMedical::factory()->count($count_seed * 3)->create();
            }
            if ((!EmployeesSchool::exists() && true) || $rebase) {
                dump('EmployeesSchool');
                EmployeesSchool::truncate();
                EmployeesSchool::factory()->count($count_seed * 3)->create();
            }
        }
    }
}
