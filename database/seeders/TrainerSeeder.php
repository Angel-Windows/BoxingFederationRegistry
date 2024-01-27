<?php

namespace Database\Seeders;

use App\Models\Class\Trainer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TrainerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Trainer::truncate();
        Trainer::factory()->count(10)->create();
    }
}
