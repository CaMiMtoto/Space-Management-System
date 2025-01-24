<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\MaintenanceTypeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|MaintenanceType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MaintenanceType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MaintenanceType query()
 * @method static \Illuminate\Database\Eloquent\Builder|MaintenanceType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaintenanceType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaintenanceType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaintenanceType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaintenanceType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MaintenanceType extends Model
{
    use HasFactory;
}
