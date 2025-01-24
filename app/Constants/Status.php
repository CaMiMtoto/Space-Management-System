<?php

namespace App\Constants;

class Status
{
    const Draft = 'Draft';
    const Submitted = 'Submitted';
    const Rejected = 'Rejected';
    const Approved = 'Approved';
    const Cancelled = 'Cancelled';

    const Available = 'Available';
    const Booked = 'Booked';
    const UnderMaintenance = 'Under Maintenance';

    const Confirmed = 'Confirmed';
    const Completed = 'Completed';
    const OutOfService = 'Out of Service';
    const UnderConstruction = 'Under Construction';
    const Active = 'Active';
    const Inactive = 'Inactive';
    const InProgress = "In Progress";
    const Scheduled = "Scheduled";
    const Unknown = "Unknown";
    const Pending = "Pending";


    public static function roomStatuses(): array
    {
        return [
            self::Available,
            self::OutOfService,
        ];
    }

    public static function buildingStatuses(): array
    {
        return [
            self::Active,
            self::Inactive,
            self::UnderMaintenance,
        ];
    }


}
