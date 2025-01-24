<?php

namespace App\Models;

use App\Traits\HasEncodedId;
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
 * @method static \Illuminate\Database\Eloquent\Builder|BuildingType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BuildingType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BuildingType query()
 * @method static \Illuminate\Database\Eloquent\Builder|BuildingType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildingType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildingType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildingType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildingType whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildingType whereUpdatedAt($value)
 * @method static \Database\Factories\BuildingTypeFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
class BuildingType extends Model
{
    use HasEncodedId,HasFactory;
}
