<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static inRandomOrder()
 */
class Federation extends Model
{
    use HasFactory;

    public $timestamps = false;
}
