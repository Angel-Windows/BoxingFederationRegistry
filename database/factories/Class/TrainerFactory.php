<?php

namespace Database\Factories\Class;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Class\Trainer>
 */
class TrainerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $history_work = [];
        $rand_count_work = random_int(1, 8);
        $now = time(); // Получаем текущее время в виде временного штампа
        for ($i = 0; $i < $rand_count_work; $i++) {
            $start_date = strtotime("2022-01-01");
            $random_start_timestamp = mt_rand($start_date, $now); // Генерируем случайный временной штамп для начала работы
            $random_end_timestamp = mt_rand($random_start_timestamp, $now); // Генерируем случайный временной штамп для конца работы
            $random_start_date = date("Y-m", $random_start_timestamp);
            $random_end_date = date("Y-m", $random_end_timestamp);
            $history_work[] = [
                'name' => $this->faker->name(),
                'start_work' => $random_start_date,
                'end_work' => $random_end_date
            ];
        }
        return [
            'logo' => $this->faker->imageUrl(),
            'name' => $this->faker->firstName() . " " . $this->faker->lastName() . " " . $this->faker->firstName(),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->email(),
            'qualification' => $this->faker->text(50),
            'federation' => $this->faker->text(random_int(30, 50)),
            'address' => $this->faker->address(),
            'rank' => $this->faker->text(random_int(30, 50)),
            'gov' => $this->faker->text(random_int(30, 50)),
            'school' => $this->faker->text(random_int(30, 50)),
            'history_work' => json_encode($history_work),
        ];
    }
}
