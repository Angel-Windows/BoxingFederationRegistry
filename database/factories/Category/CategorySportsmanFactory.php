<?php

namespace Database\Factories\Category;

use App\Models\Category\CategorySchool;
use App\Models\Category\CategorySportsInstitutions;
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
    public $sports_institutions = null;
    private function passportRand(){
        return json_encode([
            'seria'=>  strtoupper($this->faker->randomLetter() . $this->faker->randomLetter()),
            'number'=> $this->faker->numberBetween(10000000, 99999999),
        ]);
    }
    public function definition(): array
    {

        if (!$this->federation) {
            $this->federation = BoxFederation::all();
            $this->trainer = CategoryTrainer::all();
            $this->sports_institutions = CategorySportsInstitutions::all();
        }
        $rand_federation = $this->federation->random()->id;
        $rand_trainer = $this->trainer->random()->id;
        $rand_sports_institutions = $this->sports_institutions->random()->id;
        $address_address = randomAddress();

        $family = [];
        $arr_family_status = ['Тато', 'Мама', 'Брат', 'Сестра', 'Дідусь', 'Син', 'Дочка', 'Друг', 'Інше'];
        for ($i = 0; $i < random_int(0, 5); $i++) {
            $family[] = [
                'name' => $this->faker->name,
                'status' => $arr_family_status[array_rand($arr_family_status)],
                'phone' => getRandomPhone(),
            ];
        }

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
            'foreign_passport' => $this->passportRand(),
            'passport' => $this->passportRand(),
            'federation' => $rand_federation,
            'trainer' => $rand_trainer,
            'sports_institutions' => $rand_sports_institutions,
            'achievements' => $this->faker->sentence,
            'rank' => random_int(0, 4),
            'family' => json_encode($family),
            'category_sports_institutions' => random_int(0, 4),
        ];
    }
}
