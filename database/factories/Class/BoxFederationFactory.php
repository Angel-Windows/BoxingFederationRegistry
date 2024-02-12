<?php

namespace Database\Factories\Class;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Class\BoxFederation>
 */
class BoxFederationFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws \Exception
     */

    public function definition(): array
    {
        $address = randomAddress();
        return [
            'name' => $this->faker->name(),
            'director' => $this->faker->name,
            'address' => $address,
            'phone' => getRandomPhone(),
            'email' => $this->faker->email(),
            'federation' => random_int(0, 10),
            'edrpou' => random_int(100000000, 999999999),
            'site' => $this->faker->url(),
        ];
    }
}
