<?php

namespace Database\Factories\Category;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category\CategoryEmployessInstitutions>
 */
class CategoryEmployessInstitutionsFactory extends Factory
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
            'birthday' => $this->faker->date,
            'position' => $this->faker->text(10),
            'address' => $this->faker->address,
        ];
    }
}
