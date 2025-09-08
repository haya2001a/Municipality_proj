<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class ComplaintStatusChanged extends Notification
{
    use Queueable;

    private $response;
    private $newStatus;
    private $title;

    public function __construct($response, $newStatus, $title)
    {
        $this->response = $response;
        $this->newStatus = $newStatus;
        $this->title = $title;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'response' => $this->response,
            'new_status' => $this->newStatus,
            'title' => $this->title,
            'message' => "تحديث بخصوص شكواك '{$this->title}': الحالة أصبحت {$this->newStatus}، والرد هو: {$this->response}"
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'response' => $this->response,
            'new_status' => $this->newStatus,
            'title' => $this->title,
            'message' => "تحديث بخصوص شكواك '{$this->title}': الحالة أصبحت {$this->newStatus}، والرد هو: {$this->response}"

        ]);
    }
}
