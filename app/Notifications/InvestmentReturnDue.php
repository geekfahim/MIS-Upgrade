<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class InvestmentReturnDue extends Notification
{
    use Queueable;

    protected string $title;
    protected string $message;
    protected string $route;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(array $array)
    {
        $this->title = $array['title'];
        $this->message = $array['message'];
        $this->route = $array['route'];
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'title'      => $this->title,
            'message'    => $this->message,
            'route_name' => $this->route,
        ];
    }
}
