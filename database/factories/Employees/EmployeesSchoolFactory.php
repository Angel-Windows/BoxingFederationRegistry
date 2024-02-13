<?php

namespace Database\Factories\Employees;

use App\Models\Category\CategoryInsurance;
use App\Models\Category\CategorySchool;
use App\Traits\DataTypeTrait;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employees\EmployeesSchool>
 */
class EmployeesSchoolFactory extends Factory
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
        $position = $this->data_option['employees_school']['position'];
        if (!$this->model_name) {
            $this->model_name = CategorySchool::all();
        }
        $rand_model = $this->model_name->random()->id;

        return [
            'logo' => RandPhoto(),
            'school_id' => $rand_model,
            'name' => $this->faker->name,
            'address' => randomAddress(),
            'phone' => getRandomPhone(),
            'email' => $this->faker->email,
            'birthday' => $this->faker->date,
            'position' => array_rand($position),
        ];
    }
}
