<?php

namespace Database\Factories\Category;

use App\Models\Category\CategorySchool;
use App\Models\Category\CategoryTrainer;
use App\Models\Class\BoxFederation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @property \Illuminate\Database\Eloquent\Collection $school
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
    public $school = null;

    public function definition(): array
    {

        if (!$this->federation){
            $this->federation = BoxFederation::all();
            $this->trainer = CategoryTrainer::all();
            $this->school = CategorySchool::all();
        }
        $rand_federation = $this->federation->random()->id;
        $rand_trainer = $this->trainer->random()->id;
        $rand_school = $this->school->random()->id;
        $address_address = randomAddress();
        return [
            'name' => $this->faker->name,
            'phone' => getRandomPhone(),
            'email' => $this->faker->unique()->safeEmail,
            'logo' => RandPhoto(),
            'birthday' => $this->faker->date,
            'gender' => $this->faker->randomElement([0, 1]),
            'arm_height' => $this->faker->numberBetween(50, 100),
            'weight' => $this->faker->numberBetween(50, 100),
            'height' => $this->faker->numberBetween(150, 200),
            'weight_category' => $this->faker->numberBetween(1, 10),
            'address_birth' => $this->faker->city,
            'address' => $address_address,
            'foreign_passport' => $this->faker->numerify('CC#########'),
            'passport' => $this->faker->numerify('#########'),
            'federation' => $rand_federation,
            'trainer' => $rand_trainer,
            'school' => $rand_school,
            'achievements' => $this->faker->sentence,
            'rank' => random_int(0, 4),
            'category_sports_institutions' => random_int(0, 4),
        ];
    }
}
