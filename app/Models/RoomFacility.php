<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $room_id
 * @property string $name e.g., Projector, Whiteboard, Wi-Fi, etc.
 * @property int $quantity if there are multiple instances of the same facility in a room
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|RoomFacility newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RoomFacility newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RoomFacility query()
 * @method static \Illuminate\Database\Eloquent\Builder|RoomFacility whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomFacility whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomFacility whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomFacility whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomFacility whereRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomFacility whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class RoomFacility extends Model
{
    use HasFactory;
}
