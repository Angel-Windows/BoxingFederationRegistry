<?php

namespace Database\Factories\Category;

use App\Models\Category\CategorySchool;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category\CategoryEmployessSchool>
 */
class CategoryEmployessSchoolFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    private $school = null;
    public function definition(): array
    {
        if (!$this->school){
            $this->school = CategorySchool::all();
        }
        $rand_school = $this->school->random()->id ?? null;

        return [
            'name' => $this->faker->name,
            'phones' => json_encode(getRandomPhone()),
            'email' => $this->faker->unique()->safeEmail,
            'logo' => $this->faker->imageUrl,
            'school'=> $rand_school,
            'birthday' => $this->faker->date,
            'address' => $this->faker->address,
            'position' => $this->faker->text(10),

        ];
    }
}
