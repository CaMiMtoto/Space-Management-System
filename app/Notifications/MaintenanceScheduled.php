<?php

namespace App\Notifications;

use App\Models\Room;
use App\Models\RoomMaintenance;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use function Pest\Laravel\json;

class MaintenanceScheduled extends Notification implements ShouldQueue
{
    use Queueable;

    public RoomMaintenance $maintenanceRecord;

    public function __construct(RoomMaintenance $maintenanceRecord)
    {
        $this->maintenanceRecord = $maintenanceRecord;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('A maintenance task has been scheduled')
            ->line('Room: ' . $this->maintenanceRecord->room->name)
            ->line('Room Type:' . $this->maintenanceRecord->room->roomType->name)
            ->line('Room Number:' . $this->maintenanceRecord->room->room_number)
            ->line('Task: ' . $this->maintenanceRecord->maintenanceType->name)
            ->line('Start Date: ' . $this->maintenanceRecord->start_date)
            ->line('End Date: ' . $this->maintenanceRecord->end_date)
            ->line('Description: ' . $this->maintenanceRecord->description)
            ->line('Thank you for keeping our facilities in top condition!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'Maintenance Scheduled',
            'room_id' => $this->maintenanceRecord->room_id,
            'room_name' => $this->maintenanceRecord->room->name,
            'room_type' => $this->maintenanceRecord->room->roomType->name,
            'room_number' => $this->maintenanceRecord->room->room_number,
            'task' => $this->maintenanceRecord->maintenanceType->name,
            'details' => $this->maintenanceRecord->toArray()
        ];
    }
}
