<?php

namespace App\Listeners;

use App\Events\CertificateGenerated;
use App\Models\Certificate;
use App\Notifications\CertificateIssuedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class SendCertificateIssuedNotification implements ShouldQueue
{
    public string $queue = 'notifications';

    public function handle(CertificateGenerated $event): void
    {
        $certificate = Certificate::with('user')->findOrFail($event->certificateId);

        Notification::send($certificate->user, new CertificateIssuedNotification($certificate));
    }
}