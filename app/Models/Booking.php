<?php

namespace App\Models;

use App\Constants\Permission;
use App\Constants\Status;
use App\Traits\HasEncodedId;
use App\Traits\HasStatusColor;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use OwenIt\Auditing\Contracts\Auditable;

/**
 *
 *
 * @property int $id
 * @property int $room_id
 * @property int $user_id
 * @property string $start_date
 * @property string $end_date
 * @property string|null $purpose
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Booking newModelQuery()
 * @method static Builder|Booking newQuery()
 * @method static Builder|Booking query()
 * @method static Builder|Booking whereCreatedAt($value)
 * @method static Builder|Booking whereEndDate($value)
 * @method static Builder|Booking whereId($value)
 * @method static Builder|Booking wherePurpose($value)
 * @method static Builder|Booking whereRoomId($value)
 * @method static Builder|Booking whereStartDate($value)
 * @method static Builder|Booking whereStatus($value)
 * @method static Builder|Booking whereUpdatedAt($value)
 * @method static Builder|Booking whereUserId($value)
 * @property string|null $booking_code
 * @property int|null $guests
 * @property int $is_guest_booking
 * @property string|null $guest_name
 * @property string|null $guest_email
 * @property string|null $guest_phone
 * @property int|null $reviewed_by_id
 * @property string|null $reviewed_at
 * @property string|null $approval_type
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FlowHistory> $flow
 * @property-read int|null $flow_count
 * @property-read string $status_color
 * @property-read \App\Models\Invoice|null $invoice
 * @property-read \App\Models\Room $room
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Service> $services
 * @property-read int|null $services_count
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\BookingFactory factory($count = null, $state = [])
 * @method static Builder|Booking whereApprovalType($value)
 * @method static Builder|Booking whereBookingCode($value)
 * @method static Builder|Booking whereGuestEmail($value)
 * @method static Builder|Booking whereGuestName($value)
 * @method static Builder|Booking whereGuestPhone($value)
 * @method static Builder|Booking whereGuests($value)
 * @method static Builder|Booking whereIsGuestBooking($value)
 * @method static Builder|Booking whereReviewedAt($value)
 * @method static Builder|Booking whereReviewedById($value)
 * @mixin Eloquent
 */
class Booking extends Model implements Auditable
{
    use HasStatusColor, HasEncodedId, HasFactory, \OwenIt\Auditing\Auditable;

    protected $appends = ['status_color'];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    // getter for status
    public function getStatusAttribute($value): string
    {
        return ucfirst($value);
    }

    protected static function boot(): void
    {
        parent::boot();

        static::created(function ($booking) {
            // Generate booking code after the booking has been created
            $booking->booking_code = Booking::generateBookingCode($booking);
            $booking->save();
        });
    }

    public static function generateBookingCode($booking): string
    {
        // Combine the booking ID and room ID to form part of the booking code
        $code = $booking->id . $booking->room_id;

        // Pad the code to a length of 10 and prefix with "BKG"
        // Ensure the code is unique
        return 'BKG' . str_pad($code, 5, '0', STR_PAD_LEFT);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function flow(): MorphMany
    {
        return $this->morphMany(FlowHistory::class, 'flowable', 'model_type', 'model_id');
    }


    public function canBeCanceled(): bool
    {
        return auth()->user()->can(Permission::CancelBooking) && strtolower($this->status) != strtolower(Status::Cancelled);
        /*        $bookingStatus = strtolower($this->status);
                $pendingStatus = strtolower(Status::Pending);
                if ($bookingStatus != $pendingStatus)
                    return false;
                // the logged-in user is the owner of the booking or have the permission to cancel bookings
                return auth()->user()->id == $this->user_id || auth()->user()->can(Permission::CancelBooking);*/
    }

    public function canBeReviewed()
    {
        $bookingStatus = strtolower($this->status);
        $pendingStatus = strtolower(Status::Pending);
        if ($bookingStatus != $pendingStatus)
            return false;
        // the logged-in user  have the permission to review bookings
        return auth()->user()->can(Permission::ReviewBooking);
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'booking_service')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }
}
