<?php

namespace App\Notifications;

use App\Notifications\Channels\QiscusChannel;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class ResetPasswordRequest extends Notification
{
    public string $token;

    public string $channelType;

    public string $identifier;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $token, string $channelType, string $identifier)
    {
        $this->token = $token;
        $this->channelType = $channelType;
        $this->identifier = $identifier;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return $this->channelType === 'whatsapp'
            ? [QiscusChannel::class]
            : ['mail'];
    }

    public function toQiscus(object $notifiable): array
    {
        $paramKey = $this->channelType === 'whatsapp' ? 'phone' : 'email';

        $suffix = $this->token.'?'.$paramKey.'='.urlencode($this->identifier);

        return [
            'template_key' => 'password_reset',
            'button' => [$suffix],
        ];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return $this->buildMailMessage($this->resetUrl($notifiable));
    }

    /**
     * Get the reset password notification mail message for the given URL.
     *
     * @param  string  $url
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    protected function buildMailMessage($url)
    {
        return (new MailMessage)
            ->subject(Lang::get('Reset Password Notification'))
            ->line(Lang::get('You are receiving this email because we received a password reset request for your account.'))
            ->action(Lang::get('Reset Password'), $url)
            ->line(Lang::get('This password reset link will expire in :count minutes.', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]))
            ->line(Lang::get('If you did not request a password reset, no further action is required.'));
    }

    /**
     * Get the reset URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function resetUrl($notifiable)
    {
        return url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));
    }
}
