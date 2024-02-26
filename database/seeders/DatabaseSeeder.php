<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category\CategoryTrainer;
use Database\Factories\Linking\LinkingMembersFactory;
use Database\Seeders\Linking\LinkingMembersSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([

            ClassTypeSeeder::class,

//
//            ClassSeeder::class,

            ConfigSeeder::class,

//            LinkingMembersSeeder::class,

        ]);
    }
}
