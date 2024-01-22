<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static truncate()
 * @method static limit(int $int)
 * @method static where(string $string, string $string1, mixed $search_value)
 */
class UserProfile extends Model
{
    use HasFactory;
    public function getFoolNameAttribute(): string
    {
        return $this->first_name . " " . $this->last_name;
    }
}
