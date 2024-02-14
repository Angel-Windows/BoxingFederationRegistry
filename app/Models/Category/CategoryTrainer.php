<?php

namespace App\Models\Category;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static truncate()
 * @method static find($profile_id)
 * @method static exists()
 * @method static pluck(string $string, string $string1)
 * @method static where(string $string, $id)
 * @property mixed $gov
 * @property mixed $rank
 */
class CategoryTrainer extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

}
