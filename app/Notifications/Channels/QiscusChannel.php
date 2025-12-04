<?php

namespace App\Notifications\Channels;

use App\Services\QiscusService;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class QiscusChannel
{
    /**
     * Send the given notification.
     */
    public function send(object $notifiable, Notification $notification): void
    {
        if (! method_exists($notification, 'toQiscus')) {
            return;
        }

        $data = $notification->toQiscus($notifiable);

        try {
            app(QiscusService::class)->sendNotification(
                $notifiable,
                $data['template_key'],
                $data['header'] ?? [],
                $data['body'] ?? [],
                $data['button'] ?? []
            );
        } catch (\Exception $e) {
            Log::error('Qiscus Channel Error: '.$e->getMessage());
        }
    }
}
