<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $count_create = 100;

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::query()->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        UserProfile::query()->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        dump('Users start');
        User::factory()->count($count_create)->create();
        dump('Users finish');

        UserProfile::factory()->count($count_create)->create();
    }
}
