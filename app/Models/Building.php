<?php

namespace App\Models;

use App\Traits\HasEncodedId;
use App\Traits\HasStatusColor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $building_type_id
 * @property int|null $floors
 * @property int|null $rooms
 * @property string|null $address
 * @property string|null $intended_use
 * @property string|null $description
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\BuildingType $buildingType
 * @property-read string $status_color
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @method static \Illuminate\Database\Eloquent\Builder|Building newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Building newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Building query()
 * @method static \Illuminate\Database\Eloquent\Builder|Building whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Building whereBuildingTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Building whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Building whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Building whereFloors($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Building whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Building whereIntendedUse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Building whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Building whereRooms($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Building whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Building whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Building whereUpdatedAt($value)
 * @method static \Database\Factories\BuildingFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
class Building extends Model implements HasMedia
{
    use HasEncodedId,HasStatusColor,InteractsWithMedia,HasFactory;

    protected $appends = ['status_color'];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images')->useFallbackUrl('/images/default-room.jpg');
    }
    public function buildingType(): BelongsTo
    {
        return $this->belongsTo(BuildingType::class);
    }
}
