<?php

namespace App\Models\Class;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * @method static create(string[] $array)
 * @method static truncate()
 * @method static insert(array[] $array)
 * @method static get()
 * @method static where(string $string, string $class_types)
 */
class ClassType extends Model
{
    public static function getCache($id = null)
    {
        $all_type = Cache::remember('class_types', 1, static fn() => self::all());
        return $id ? $all_type[$id] : $all_type;
    }
}
