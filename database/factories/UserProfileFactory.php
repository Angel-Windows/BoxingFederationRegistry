<?php

namespace Database\Factories;

use App\Models\Federation;
use App\Models\Qualification;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserProfile>
 */
class UserProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected static int $userIdCounter = 1;

    public function definition(): array
    {
        $qualification = Qualification::inRandomOrder()->first();
        $federation = Federation::inRandomOrder()->first();
        $userId = self::$userIdCounter++;
        return [

            'user_id' => $userId,
            'federation_id' => $federation->id,
            'qualification_id' => $qualification->id,

            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'surname' => $this->faker->firstName . "s",

            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),

            'honors_and_awards' => $this->faker->name(),
            'rewards' => $this->faker->name(),
            'education_place' => $this->faker->name(),

        ];
    }
}
