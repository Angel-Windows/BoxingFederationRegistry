<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public static int $ids = 0;
    public function definition(): array
    {
        $new_login = 'user_' . self::$ids;
        $new_email = $new_login . "@gmail.com";
        self::$ids++;
        return [
            'login' => $new_login,
            'email' => $new_email,
            'email_verified_at' => '2024-01-07 21:11:36',
            'password' =>  \Hash::make('qwerty123'),
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'remember_token' => Str::random(10),
            'profile_photo_path' => null,
            'balance' => 0,
        ];
    }
}
