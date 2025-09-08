<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class TradeStatusChanged extends Notification
{
    use Queueable;

    private $trade;
    private $fees;

    public function __construct($trade, $fees)
    {
        $this->trade = $trade;
        $this->fees = $fees;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        $message = "تم تغيير حالة الرخصة إلى {$this->trade->status}";

        if ($this->fees > 0) {
            $message .= "، والمبلغ المدفوع بالدينار: " . number_format($this->fees, 2);
        }

        return [
            'message' => $message,
            'trade_id' => $this->trade->id,
            'status' => $this->trade->status,
            'paid_fees' => $this->fees,
        ];
    }

    public function toBroadcast($notifiable)
    {
        $message = "تم تغيير حالة الرخصة إلى {$this->trade->status}";

        if ($this->fees > 0) {
            $message .= "، والمبلغ المدفوع بالدينار: " . number_format($this->fees, 2);
        }

        return new BroadcastMessage([
            'message' => $message,
            'trade_id' => $this->trade->id,
            'status' => $this->trade->status,
            'paid_fees' => $this->fees,
        ]);
    }
}
