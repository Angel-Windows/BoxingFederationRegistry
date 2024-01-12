<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HistoryWork>
 */
class HistoryWorkFactory extends Factory
{
    public static array $data_attr = [];
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user_id = self::$data_attr['user_id'];
        $work_time_start = $this->faker->dateTimeBetween('2009-01-01', '2023-12-31')->format('Y-m-d H:i:s');
        $work_time_end = $this->faker->dateTimeBetween($work_time_start)->format('Y-m-d H:i:s');
        return [
            'user_id' => $user_id,
            'work_id' => 1,
            'start_at' => $work_time_start,
            'end_at' => $work_time_end,
        ];
    }
    public static function setRagToRed($data_attr): array
    {
        self::$data_attr = $data_attr;

        return [];
    }
}
