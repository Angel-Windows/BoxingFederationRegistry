<?php

namespace Database\Factories\Category;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category\CategorySchool>
 */
class CategorySchoolFactory extends Factory
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
            'logo' => $this->faker->imageUrl,
            'address' => $this->faker->address,
            'director' => $this->faker->name,
        ];
    }
}
