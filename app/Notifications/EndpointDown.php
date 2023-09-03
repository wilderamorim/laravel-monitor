<?php

namespace App\Notifications;

use App\Models\Check;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EndpointDown extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected Check $check)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $endpoint = $this->check->endpoint;
        $site = $endpoint->site;

        return (new MailMessage)
            ->error()
            ->subject(sprintf('O site "%s" está com erro.', $site->url))
            ->line(sprintf('O endpoint "%s" obteve o status "%s".', $endpoint->endpoint, $this->check->status_code))
            ->action('Ver', route('logs.index', $endpoint->id))
            ->line('Obrigado por utilizar a nossa aplicação!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
