<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\HasEncodedId;
use App\Traits\HasStatusColor;
use App\Traits\HasStatusIcon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property int $id
 * @property int $room_id
 * @property string $maintenance_date
 * @property string $description
 * @property string $maintenance_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|RoomMaintenance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RoomMaintenance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RoomMaintenance query()
 * @method static \Illuminate\Database\Eloquent\Builder|RoomMaintenance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomMaintenance whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomMaintenance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomMaintenance whereMaintenanceDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomMaintenance whereMaintenanceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomMaintenance whereRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomMaintenance whereUpdatedAt($value)
 * @property int $maintenance_type_id
 * @property \Illuminate\Support\Carbon $start_date
 * @property \Illuminate\Support\Carbon|null $end_date
 * @property string $status
 * @property string|null $assigned_technician
 * @property string|null $scheduled_at
 * @property string|null $completed_at
 * @property-read string $status_color
 * @property-read string $status_icon
 * @property-read \App\Models\MaintenanceType $maintenanceType
 * @property-read \App\Models\Room $room
 * @method static \Illuminate\Database\Eloquent\Builder|RoomMaintenance whereAssignedTechnician($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomMaintenance whereCompletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomMaintenance whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomMaintenance whereMaintenanceTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomMaintenance whereScheduledAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomMaintenance whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomMaintenance whereStatus($value)
 * @mixin \Eloquent
 */
class RoomMaintenance extends Model
{
    use HasStatusColor, HasEncodedId, HasStatusIcon;

    protected $appends = ['status_color', 'status_icon'];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function room(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Room::class);
    }


    public function maintenanceType(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(MaintenanceType::class);
    }

    // let's reconstruct statuses according to dates of Room maintenance
    public function getStatusAttribute(): string
    {
        $now = now();
        $start = $this->start_date->startOfDay();
        $end = $this->end_date->endOfDay();

        if ($now->isBefore($start)) {
            return Status::Scheduled;
        }

        if ($now->isAfter($start) && $now->isBefore($end)) {
            return Status::InProgress;
        }

        if ($now->isAfter($end)) {
            return Status::Completed;
        }

        return Status::Unknown;
    }

}
