<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewReservationNotification extends Notification
{
    use Queueable;

    protected $building, $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($building, $user)
    {
        $this->building = $building;
        $this->user = $user;
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
                    ->subject(config('app.name') . ': New Reservation')
                    ->greeting('Hello ' . $notifiable->renderFullname() . ',')
                    ->line('A new reservation come from the website to our one of the building '. $this->building->name)
                    ->line('Name : '. $this->user->renderFullname())
                    ->line('Email : '. $this->user->email)
                    ->line('Contact # : '. $this->user->userDetail->contact)
                    ->line('Company : '. $this->user->userDetail->company)
                    ->line('Monthly Earning : '. $this->user->userDetail->monthly_earning)
                    ->line('Our dear customer is waiting. Please review the application to approve.')
                    ->action('Review Application', route('applicants'));
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
