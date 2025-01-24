<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|OccupancyType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OccupancyType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OccupancyType query()
 * @method static \Illuminate\Database\Eloquent\Builder|OccupancyType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OccupancyType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OccupancyType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OccupancyType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OccupancyType whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OccupancyType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OccupancyType extends Model
{
    use HasFactory;
}
