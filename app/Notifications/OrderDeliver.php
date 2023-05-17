<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderDeliver extends Notification
{
    use Queueable;
    private $order_id;
    private $user_create;

    /**
     * Create a new notification instance.
     */
    public function __construct ($order_id, $user_create)
    {
        $this->order_id = $order_id;
        $this->user_create = $user_create;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toDatabase($notifiable)
    {
        return [
            'id' => $this->order_id,
            'title' => ' تم توصيل الطلب بنجاح بواسطه :',
            'user' => $this->user_create
        ];
    }   
}
