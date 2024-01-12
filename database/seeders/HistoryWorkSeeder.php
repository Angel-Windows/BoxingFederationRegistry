<?php

namespace Database\Seeders;

use App\Models\HistoryWork;
use App\Models\User;
use Database\Factories\HistoryWorkFactory;
use Exception;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class HistoryWorkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @throws Exception
     */
    public function run(): void
    {
        HistoryWork::truncate();
        $users = User::all();
        foreach ($users as $item) {
            $data_attr = [
                'user_id' => $item->id,
            ];
            HistoryWork::factory()
                ->count(random_int(0, 10))
                ->state(new Sequence(
                    HistoryWorkFactory::setRagToRed($data_attr),
                ))
                ->create();

        }
    }

}
