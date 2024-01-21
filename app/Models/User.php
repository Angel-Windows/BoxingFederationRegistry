<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property mixed $qualifications_name
 * @property mixed $federations_name
 * @property mixed $address
 * @property mixed $rewards
 * @property mixed $education_place
 * @property mixed $honors_and_awards
 */
class User extends Authenticatable
{
    use HasFactory;
}
