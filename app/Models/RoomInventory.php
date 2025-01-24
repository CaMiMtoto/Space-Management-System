<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * 
 *
 * @property int $id
 * @property int $room_id
 * @property string $item_name
 * @property int|null $quantity
 * @property string|null $unit_of_measure
 * @property string|null $description
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Room $room
 * @method static \Illuminate\Database\Eloquent\Builder|RoomInventory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RoomInventory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RoomInventory query()
 * @method static \Illuminate\Database\Eloquent\Builder|RoomInventory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomInventory whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomInventory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomInventory whereItemName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomInventory whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomInventory whereRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomInventory whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomInventory whereUnitOfMeasure($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomInventory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class RoomInventory extends Model
{
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
}
