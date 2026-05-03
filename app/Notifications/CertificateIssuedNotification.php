<?php

namespace App\Notifications;

use App\Models\Certificate;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CertificateIssuedNotification extends Notification
{
    use Queueable;

    public Certificate $certificate;

    public function __construct(Certificate $certificate)
    {
        $this->certificate = $certificate;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your certificate is ready')
            ->greeting('Hello ' . $notifiable->full_name)
            ->line('Your certificate has been generated successfully.')
            ->action('Download Certificate', route('certificates.download', $this->certificate->id))
            ->line('Certificate No: ' . $this->certificate->certificate_number);
    }
}