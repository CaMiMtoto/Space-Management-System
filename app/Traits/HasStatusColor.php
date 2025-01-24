<?php

namespace App\Traits;

use App\Constants\Status;

trait HasStatusColor
{
    public function getStatusColorFromTrait(): string
    {
        $status = strtolower($this->status);

        return match ($status) {
            strtolower(Status::UnderMaintenance),
            strtolower(Status::Pending) => 'warning',

            strtolower(Status::Submitted),
            strtolower(Status::InProgress),
            strtolower(Status::Confirmed) => 'info',

            strtolower(Status::Scheduled) => 'primary',

            strtolower(Status::Available),
            'active',
            strtolower(Status::Completed),
            strtolower(Status::Approved) => 'success',

            strtolower(Status::Rejected),
            strtolower(Status::Cancelled),
            strtolower(Status::OutOfService),
            'inactive',
            strtolower(Status::Booked) => 'danger',

            default => 'secondary',
        };
    }

    // Keep the original method (optional)
    public function getStatusColorAttribute(): string
    {
        return $this->getStatusColorFromTrait();
    }
}
