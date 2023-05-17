<?php

namespace App\Notifications;

use App\Models\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewUserNoti extends Notification
{
    use Queueable;
    private $clients;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Client $clients)
    {
        $this->clients = $clients;
    }
    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
  

    /**
     * Get the mail representation of the notification.
     */
  
    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function via($notifiable)
    {
        return ['database'];
    }


    public function toDatabase($notifiable)
    {
        return [

            //'data' => $this->details['body']
            'id' => $this->clients->id,
            'title' => 'لديك مشترك جديد :',
            'user' => $this->clients->number,

        ];
    }



}
