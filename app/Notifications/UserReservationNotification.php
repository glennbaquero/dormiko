<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserReservationNotification extends Notification
{
    use Queueable;

    protected $building;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($building)
    {
        $this->building = $building;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject(config('app.name') . ': Reservation to Dormiko')
                    ->greeting('Hello ' . $notifiable->renderFullname() . ',')
                    ->line('Your email is used for reservation from Dormiko to building '. $this->building->name)
                    ->action('Visit DormikoPH', route('home'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
