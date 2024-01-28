<?php

namespace Database\Factories\Category;

use App\Models\Category\CategoryTrainer;
use App\Models\Class\BoxFederation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category\CategorySportsman>
 */
class CategorySportsmanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public $federation = null;
    public $trainer = null;

    public function definition(): array
    {
        if (!$this->federation){
            $this->federation = BoxFederation::all();
            $this->trainer = CategoryTrainer::all();
        }
        $rand_federation = $this->federation->random()->id;
        $rand_trainer = $this->trainer->random()->id;

        return [
            'name' => $this->faker->name,
            'phones' => json_encode(getRandomPhone()),
            'email' => $this->faker->unique()->safeEmail,
            'logo' => $this->faker->imageUrl,
            'birthday' => $this->faker->date,
            'gender' => $this->faker->randomElement([0, 1]), // Assuming 0 for male, 1 for female
            'weight' => $this->faker->numberBetween(50, 100), // Assuming weight in kg
            'height' => $this->faker->numberBetween(150, 200), // Assuming height in cm
            'weight_category' => $this->faker->numberBetween(1, 10), // Assuming weight category as an integer
            'address_birth' => $this->faker->address,
            'address_address' => $this->faker->address,
            'passport' => $this->faker->numerify('##########'),
            'federation' => $rand_federation,
            'trainer' => $rand_trainer,
            'school' => $this->faker->company,
            'achievements' => $this->faker->sentence,
            'rank' => $this->faker->word,
        ];
    }
}
