<?php

namespace App\Models\Category;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static truncate()
 * @method static exists()
 * @method static find(mixed $id)
 */
class CategoryFunZone extends Model
{
    use HasFactory;
    protected $fillable = [
        'logo',
    ];
}
