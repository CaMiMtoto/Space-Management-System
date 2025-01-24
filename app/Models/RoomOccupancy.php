<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $occupancy_type_id
 * @property int $room_id
 * @property int $user_id
 * @property string|null $purpose
 * @property string|null $start_date
 * @property string|null $end_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|RoomOccupancy newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RoomOccupancy newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RoomOccupancy query()
 * @method static \Illuminate\Database\Eloquent\Builder|RoomOccupancy whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomOccupancy whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomOccupancy whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomOccupancy whereOccupancyTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomOccupancy wherePurpose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomOccupancy whereRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomOccupancy whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomOccupancy whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomOccupancy whereUserId($value)
 * @mixin \Eloquent
 */
class RoomOccupancy extends Model
{
    use HasFactory;
}
