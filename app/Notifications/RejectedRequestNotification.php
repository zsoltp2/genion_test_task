<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RejectedRequestNotification extends Notification
{
    use Queueable;

    protected string $senderName;

    public function __construct(string $senderName) {
        $this->senderName = $senderName;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'message' => "{$this->senderName} rejected your friend request.",
            'type' => 'accepted_request'
        ];
    }
}
