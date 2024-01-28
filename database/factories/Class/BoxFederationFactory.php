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

        return [
            'name' => $this->faker->name(),
            'phones' => json_encode(getRandomPhone(2)),
            'email' => $this->faker->name(),
            'federation' => $this->faker->name(),
            'edrpou' => random_int(100000000, 999999999),
            'site' => $this->faker->url(),
        ];
    }
}
