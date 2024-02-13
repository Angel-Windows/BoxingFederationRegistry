<?php

namespace Database\Factories\Employees;

use App\Models\Category\CategoryInsurance;
use App\Models\Category\CategorySportsInstitutions;
use App\Traits\DataTypeTrait;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employees\EmployeesInsurance>
 */
class EmployeesInsuranceFactory extends Factory
{
    use DataTypeTrait;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public $model_name = null;


    public function definition(): array
    {
        $position = $this->data_option['employees_insurances']['position'];
        if (!$this->model_name) {
            $this->model_name = CategoryInsurance::all();
        }
        $rand_model = $this->model_name->random()->id;

        return [
            'logo' => RandPhoto(),
            'insurances_id' => $rand_model,
            'name' => $this->faker->name,
            'address' => randomAddress(),
            'phone' => getRandomPhone(),
            'email' => $this->faker->email,
            'birthday' => $this->faker->date,
            'position' => array_rand($position),
        ];
    }
}
