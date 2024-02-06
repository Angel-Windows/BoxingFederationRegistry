<?php

namespace Database\Factories\Category;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category\CategoryTrainer>
 */
class CategoryTrainerFactory extends Factory
{
    public function definition(): array
    {
        $address = randomAddress();

        return [
            'logo' => $this->faker->imageUrl(),
            'name' => $this->faker->firstName() . " " . $this->faker->lastName() . " " . $this->faker->firstName(),
            'phone' => getRandomPhone(1),
            'email' => $this->faker->email(),
            'qualification' => $this->faker->text(50),
            'federation' => $this->faker->text(random_int(30, 50)),
            'address' => $address,
            'rank' => $this->faker->text(random_int(30, 50)),
            'gov' => $this->faker->text(random_int(30, 50)),
            'school' => $this->faker->text(random_int(30, 50)),
        ];
    }
}
