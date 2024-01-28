<?php

namespace Database\Factories\Category;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category\CategoryJudge>
 */
class CategoryJudgeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'phones' => json_encode(getRandomPhone()),
            'email' => $this->faker->unique()->safeEmail,
            'logo' => $this->faker->imageUrl, // Adjust as needed
            'address' => $this->faker->address,
            'qualification' => $this->faker->word,
            'rank' => $this->faker->word,
            'gov' => $this->faker->word,
            'school' => $this->faker->company,
            'history_works' => json_encode([$this->faker->sentence, $this->faker->sentence]), // Adjust as needed
        ];
    }
}
