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
        $address = randomAddress();
        return [
            'name' => $this->faker->name,
            'phone' => getRandomPhone(),
            'email' => $this->faker->unique()->safeEmail,
            'logo' => $this->faker->imageUrl,
            'address' => $address,
            'director' => $this->faker->name,
        ];
    }
}
