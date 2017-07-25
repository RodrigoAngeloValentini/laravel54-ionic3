<?php

namespace CodeFlix\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class DefaultResetPasswordNotification extends ResetPassword
{
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('Você está recebendo este e-mail, poque uma redefinição de senha foi requisitada.')
                    ->action('Redefinir senha', route('password.reset', $this->token))
                    ->line('Se você não requisitou isto, por favor desconsidere');
    }
}
