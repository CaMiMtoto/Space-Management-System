<?php

use App\Http\Controllers\BookingReportController;
use App\Http\Controllers\RoomReportsController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UsersController;
use App\Http\Middleware\EnsureUserIsActive;
use App\Http\Middleware\PasswordChanged;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/clear-cache', [App\Http\Controllers\HomeController::class, 'clearCache'])->name('clear-cache');
Route::get('/test-email', function () {
    Mail::raw('This is a test email', function ($message) {
        $message->to('jeanpaulcami@live.com')
            ->subject('Test Email');
    });

    return 'Test email sent!';
});
Route::group(['prefix' => '/appointments', 'as' => 'appointments.'], function () {
    Route::get('/create', [App\Http\Controllers\AppointmentBookingController::class, 'create'])->name('create');
    Route::post('/', [App\Http\Controllers\AppointmentBookingController::class, 'store'])->name('store');
    Route::get('/{appointmentBooking}', [App\Http\Controllers\AppointmentBookingController::class, 'show'])->name('show');
});


Route::get('/', fn() => redirect('/admin/dashboard'));

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/bookings/{booking}', [App\Http\Controllers\BookingController::class, 'show'])->name('admin.bookings.show');

Route::group(['middleware' => ['auth', PasswordChanged::class, EnsureUserIsActive::class], 'prefix' => '/admin', 'as' => 'admin.'], function () {

    Route::get('/appointments', [App\Http\Controllers\AppointmentBookingController::class, 'index'])->name('appointments.index');
    Route::post('/appointments/{booking}/review', [App\Http\Controllers\AppointmentBookingController::class, 'review'])->name('appointments.review');

    Route::get('/bookings', [App\Http\Controllers\BookingController::class, 'index'])->name('bookings.index');
    Route::post('/bookings/{booking}/review', [App\Http\Controllers\BookingController::class, 'review'])->name('bookings.review');
    Route::post('/bookings/{booking}/cancel', [App\Http\Controllers\BookingController::class, 'cancelBooking'])->name('bookings.cancel');
    Route::post('/bookings/{booking}/checkout', [App\Http\Controllers\BookingController::class, 'checkout'])->name('bookings.checkout');
    Route::delete('/bookings/{booking}/destroy', [App\Http\Controllers\BookingController::class, 'destroy'])->name('bookings.destroy');
    Route::get('/bookings/create', [App\Http\Controllers\BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [App\Http\Controllers\BookingController::class, 'store'])->name('bookings.store');
    Route::group(['prefix' => "settings", "as" => "settings."], function () {
        Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
        Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
        Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show');
        Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');


    });


    Route::group(["prefix" => "system", "as" => "system."], function () {
        Route::get('/roles', [App\Http\Controllers\RolesController::class, 'index'])->name('roles.index');
        Route::post('/roles', [App\Http\Controllers\RolesController::class, 'store'])->name('roles.store');
        Route::get('/roles/{role}', [App\Http\Controllers\RolesController::class, 'show'])->name('roles.show');
        Route::delete('/roles/{role}', [App\Http\Controllers\RolesController::class, 'destroy'])->name('roles.destroy');


        Route::get('/users', [App\Http\Controllers\UsersController::class, 'index'])->name('users.index');
        Route::post('/users', [App\Http\Controllers\UsersController::class, 'store'])->name('users.store');
        Route::post('/users/{user}/toggle-activate', [App\Http\Controllers\UsersController::class, 'toggleActive'])->name('users.active-toggle');
        Route::delete('/users/{user}', [App\Http\Controllers\UsersController::class, 'destroy'])->name('users.destroy');
        Route::get('/users/{user}', [App\Http\Controllers\UsersController::class, 'show'])->name('users.show');
        Route::post('/users/import', [UsersController::class, 'import'])->name('users.import');
        Route::get('/permissions', [App\Http\Controllers\PermissionsController::class, 'index'])->name('permissions.index');

    });

    Route::group(["prefix" => "buildings", "as" => "buildings."], function () {
        Route::get('/', [App\Http\Controllers\BuildingController::class, 'index'])->name('index');
        Route::post('/', [App\Http\Controllers\BuildingController::class, 'store'])->name('store');
        Route::get('/{building}', [App\Http\Controllers\BuildingController::class, 'show'])->name('show');
        Route::delete('/{building}', [App\Http\Controllers\BuildingController::class, 'destroy'])->name('destroy');

        Route::get('/types/index', [App\Http\Controllers\BuildingTypeController::class, 'index'])->name('types.index');
        Route::get('/types/{buildingType}/show', [App\Http\Controllers\BuildingTypeController::class, 'show'])->name('types.show');
        Route::post('/types/store', [App\Http\Controllers\BuildingTypeController::class, 'store'])->name('types.store');
        Route::delete('/types/{buildingType}/destroy', [App\Http\Controllers\BuildingTypeController::class, 'destroy'])->name('types.destroy');
    });
    // rooms
    Route::group(["prefix" => "rooms", "as" => "rooms."], function () {
        Route::get('/', [App\Http\Controllers\RoomController::class, 'index'])->name('index');
        Route::post('/', [App\Http\Controllers\RoomController::class, 'store'])->name('store');
        Route::get('/{room}', [App\Http\Controllers\RoomController::class, 'show'])->name('show');
        Route::get('/{room}/details', [App\Http\Controllers\RoomController::class, 'details'])->name('details');
        Route::get('/all/type/capacity', [App\Http\Controllers\RoomController::class, 'rooms'])->name('all-by-type-capacity');
        Route::delete('/{room}', [App\Http\Controllers\RoomController::class, 'destroy'])->name('destroy');
        Route::get('/types/index', [App\Http\Controllers\RoomTypeController::class, 'index'])->name('types.index');
        Route::get('/types/{roomType}/show', [App\Http\Controllers\RoomTypeController::class, 'show'])->name('types.show');
        Route::post('/types/store', [App\Http\Controllers\RoomTypeController::class, 'store'])->name('types.store');
        Route::delete('/types/{roomType}/destroy', [App\Http\Controllers\RoomTypeController::class, 'destroy'])->name('types.destroy');

        Route::get('/{room}/maintenances', [App\Http\Controllers\RoomMaintenanceController::class, 'index'])->name('maintenances.index');
        Route::post('/{room}/maintenances', [App\Http\Controllers\RoomMaintenanceController::class, 'store'])->name('maintenances.store');
        Route::post('/maintenances/{maintenance}/complete', [App\Http\Controllers\RoomMaintenanceController::class, 'complete'])->name('maintenances.complete');
        Route::delete('/maintenances/{maintenance}', [App\Http\Controllers\RoomMaintenanceController::class, 'destroy'])->name('maintenances.destroy');

    });

    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('dashboard');

    Route::prefix('reports')->group(function () {
        Route::get('/room-utilization', [RoomReportsController::class, 'roomUtilizationReport'])->name('reports.room-utilization');
        Route::get('/peak-usage-times', [RoomReportsController::class, 'peakUsageTimes'])->name('reports.peak-usage-times');
        Route::get('/popular-rooms', [RoomReportsController::class, 'popularRooms'])->name('reports.popular-rooms');

        Route::get('/booking', [BookingReportController::class, 'index'])->name('reports.booking');
        Route::get('/booking/export', [BookingReportController::class, 'exportToExcel'])->name('booking.export');
    });


});
