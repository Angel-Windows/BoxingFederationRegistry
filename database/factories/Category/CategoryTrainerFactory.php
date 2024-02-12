<?php

namespace Database\Factories\Category;

use App\Models\Class\BoxFederation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category\CategoryTrainer>
 */
class CategoryTrainerFactory extends Factory
{
    public $federation = null;
    public function definition(): array
    {
        $address = randomAddress();
        if (!$this->federation) {
            $this->federation = BoxFederation::all();
        }
        $rand_federation = $this->federation->random()->id;
        return [
            'logo' => RandPhoto(),
            'name' => $this->faker->firstName() . " " . $this->faker->lastName() . " " . $this->faker->firstName(),
            'phone' => getRandomPhone(1),
            'email' => $this->faker->email(),
            'qualification' => $this->faker->text(50),
            'federation' => $rand_federation,
            'address' => $address,
            'rank' => $this->faker->text(random_int(30, 50)),
            'gov' => $this->faker->text(random_int(30, 50)),
            'school' => $this->faker->text(random_int(30, 50)),
        ];
    }
}
