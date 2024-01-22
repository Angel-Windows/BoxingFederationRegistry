<?php

namespace App\Models\Class;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(string[] $array)
 * @method static truncate()
 * @method static insert(array[] $array)
 * @method static get()
 * @method static where(string $string, string $class_types)
 */
class ClassType extends Model
{
    use HasFactory;
}
