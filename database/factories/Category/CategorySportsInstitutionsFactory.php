<?php

namespace Database\Factories\Category;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category\CategorySportsInstitutions>
 */
class CategorySportsInstitutionsFactory extends Factory
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
            'type' => $this->faker->randomElement(['Type A', 'Type B', 'Type C']),
            'category' => $this->faker->randomElement(['Category X', 'Category Y', 'Category Z']),
            'edrpou' => $this->faker->randomNumber(6),
            'director' => $this->faker->name,
            'site' => $this->faker->url,
        ];
    }
}