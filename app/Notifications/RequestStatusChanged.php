<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RequestStatusChanged extends Notification
{
    use Queueable;

    private $service;
    private $newStatus;
    private $oldStatus;

    public function __construct($service, $newStatus, $oldStatus)
    {
        $this->service = $service;
        $this->newStatus = $newStatus;
        $this->oldStatus = $oldStatus;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'service_id' => $this->service->id,
            'service' => $this->service->name,
            'new_status' => $this->newStatus,
            'old_status' => $this->oldStatus,
            'message' => "تم تغيير حالة طلب خدمة {$this->service->name} من {$this->oldStatus} إلى {$this->newStatus}"
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'service_id' => $this->service->id,
            'service' => $this->service->name,
            'new_status' => $this->newStatus,
            'old_status' => $this->oldStatus,
            'message' => "تم تغيير حالة طلب خدمة {$this->service->name} من {$this->oldStatus} إلى {$this->newStatus}"

        ]);
    }
}
