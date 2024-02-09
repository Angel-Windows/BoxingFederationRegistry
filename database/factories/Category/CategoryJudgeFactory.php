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
        $address = randomAddress();
        return [
            'name' => $this->faker->name,
            'phone' => getRandomPhone(),
            'email' => $this->faker->unique()->safeEmail,
            'logo' => RandPhoto(),
            'address' => $address,
            'qualification' => $this->faker->word,
            'rank' => $this->faker->word,
            'gov' => $this->faker->word,
            'school' => $this->faker->company,
            'history_works' => json_encode([$this->faker->sentence, $this->faker->sentence]),
        ];
    }
}
