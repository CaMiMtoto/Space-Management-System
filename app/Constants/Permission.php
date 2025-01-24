<?php

namespace App\Constants;

class Permission
{
    public const MANAGE_USERS = 'manage_users';
    public const MANAGE_ROOMS = 'manage_rooms';
    public const MANAGE_BUILDINGS = 'manage_buildings';
    public const MANAGE_BUILDING_TYPES = 'manage_building_types';
    public const MANAGE_ROOM_TYPES = 'manage_room_types';
    public const MANAGE_BOOKINGS = 'manage_bookings';
    public const MANAGE_ROLES = 'manage_roles';
    public const  VIEW_PERMISSIONS = 'view_permissions';
    public const MANAGE_MAINTENANCE = 'manage_maintenance';
    const CancelBooking = "cancel_booking";
    const ReviewBooking = "review_booking";
    const ManageServices = "manage_services";
    const ReviewBookingAppointments = "review_booking_appointments";
    const BOOK_VIP_ROOMS = 'book_vip_rooms';
    const VIEW_ROOM_UTILIZATION_REPORT = 'view_room_utilization_report';
    const VIEW_PEAK_USAGE_TIME_REPORT = 'view_peak_usage_time_report';
    const VIEW_POPULAR_ROOMS_REPORT = 'view_popular_rooms_report';
    const VIEW_BOOKING_REPORT = 'view_booking_report';
    const SUBMIT_BOOKING = "submit_booking";

    public static function all(): array
    {
        return [
            self::MANAGE_USERS,
            self::MANAGE_ROOMS,
            self::MANAGE_BUILDINGS,
            self::MANAGE_ROOM_TYPES,
            self::MANAGE_BOOKINGS,
            self::VIEW_PERMISSIONS,
            self::MANAGE_MAINTENANCE,
            self::MANAGE_BUILDING_TYPES,
            self::MANAGE_ROLES,
            self::CancelBooking,
            self::ReviewBooking,
            self::ManageServices,
            self::ReviewBookingAppointments,
            self::BOOK_VIP_ROOMS,
            self::VIEW_ROOM_UTILIZATION_REPORT,
            self::VIEW_PEAK_USAGE_TIME_REPORT,
            self::VIEW_POPULAR_ROOMS_REPORT,
            self::VIEW_BOOKING_REPORT,
            self::SUBMIT_BOOKING
        ];
    }

    public static function reportPermissions(): array
    {
        return [
            self::VIEW_ROOM_UTILIZATION_REPORT,
            self::VIEW_PEAK_USAGE_TIME_REPORT,
            self::VIEW_POPULAR_ROOMS_REPORT,
            self::VIEW_BOOKING_REPORT,
        ];
    }


}
