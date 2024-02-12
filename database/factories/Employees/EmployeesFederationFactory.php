<?php

namespace Database\Factories\Employees;

use App\Models\Category\CategorySportsInstitutions;
use App\Models\Category\CategoryTrainer;
use App\Models\Class\BoxFederation;
use App\Traits\DataTypeTrait;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employees\EmployeesFederation>
 */
class EmployeesFederationFactory extends Factory
{
    use DataTypeTrait;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public $federation = null;

    public function definition(): array
    {
        $position = $this->data_option['employees_federation']['position'];
        if (!$this->federation) {
            $this->federation = BoxFederation::all();
        }
        $rand_federation = $this->federation->random()->id;

        return [
            'logo' => RandPhoto(),
            'federation_id' => $rand_federation,
            'name' => $this->faker->name,
            'city' => $this->faker->city,
            'phone' => getRandomPhone(),
            'email' => $this->faker->email,
            'birthday' => $this->faker->date,
            'position' => array_rand($position),
        ];
    }
}
