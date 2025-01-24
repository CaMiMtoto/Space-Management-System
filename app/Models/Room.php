<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\HasEncodedId;
use App\Traits\HasStatusColor;
use Database\Factories\RoomFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Models\Audit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 *
 *
 * @property int $id
 * @property string $name
 * @property int $room_type_id
 * @property int $building_id
 * @property int|null $floor
 * @property string|null $room_number
 * @property int|null $capacity
 * @property string $status
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Building $building
 * @property-read string $status_color
 * @property-read MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 * @property-read RoomType $roomType
 * @method static Builder|Room newModelQuery()
 * @method static Builder|Room newQuery()
 * @method static Builder|Room query()
 * @method static Builder|Room whereBuildingId($value)
 * @method static Builder|Room whereCapacity($value)
 * @method static Builder|Room whereCreatedAt($value)
 * @method static Builder|Room whereDescription($value)
 * @method static Builder|Room whereFloor($value)
 * @method static Builder|Room whereId($value)
 * @method static Builder|Room whereName($value)
 * @method static Builder|Room whereRoomNumber($value)
 * @method static Builder|Room whereRoomTypeId($value)
 * @method static Builder|Room whereStatus($value)
 * @method static Builder|Room whereUpdatedAt($value)
 * @property-read Collection<int, Audit> $audits
 * @property-read int|null $audits_count
 * @property-read Collection<int, Booking> $bookings
 * @property-read int|null $bookings_count
 * @property-read string $details_url
 * @property-read Collection<int, RoomInventory> $inventoryItems
 * @property-read int|null $inventory_items_count
 * @property-read Collection<int, RoomMaintenance> $maintenances
 * @property-read int|null $maintenances_count
 * @method static RoomFactory factory($count = null, $state = [])
 * @mixin Eloquent
 */
class Room extends Model implements HasMedia, Auditable
{
    use InteractsWithMedia, HasStatusColor, HasEncodedId, HasFactory, \OwenIt\Auditing\Auditable;

    protected $appends = ['status_color', 'details_url'];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(368)
            ->height(232)
            ->sharpen(10);
    }

    public function roomType(): BelongsTo
    {
        return $this->belongsTo(RoomType::class);
    }

    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    // A room can have many maintenance records
    public function maintenances(): HasMany
    {
        return $this->hasMany(RoomMaintenance::class);
    }

    // Check if the room is under maintenance
    // Check if the room is under maintenance using the loaded maintenances
    public function isUnderMaintenance(): bool
    {
        $now = now()->toDateString(); // Current date

        // Since maintenances are already eager loaded, use the collection to filter
        return $this->maintenances->filter(function ($maintenance) use ($now) {
            return $maintenance->start_date <= $now
                && $maintenance->end_date >= $now;
        })->isNotEmpty();
    }
/*
    public function isUnderMaintenance(): bool
    {
        $now = now()->toDateString(); // Current date and time
        // Check if there is any active maintenance within the date range for this room
        return $this->maintenances()
            ->whereDate('start_date', '<=', $now) // Maintenance has started
            ->whereDate('end_date', '>=', $now)   // Maintenance has not ended
            ->exists(); // If such a maintenance record exists, the room is under maintenance
    }*/


    // Room.php

    // Override the status color attribute to handle maintenance
    public function getStatusColorAttribute(): string
    {
        // If the room is under maintenance, return 'warning'
        if ($this->isUnderMaintenance()) {
            return 'warning';
        }

        // Otherwise, use the status color from the trait
        return $this->getStatusColorFromTrait();
    }

    public function getStatusAttribute()
    {
        // If the room is under maintenance, return 'maintenance'
        if ($this->isUnderMaintenance()) {
            return Status::UnderMaintenance;
        }
        // Otherwise, use the status from the database
        return $this->attributes['status'];
    }

    public function getDetailsUrlAttribute(): string
    {
        return route('admin.rooms.details', encodeId($this->attributes['id']));
    }

    public function inventoryItems(): HasMany
    {
        return $this->hasMany(RoomInventory::class);
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'room_service');
    }
}
