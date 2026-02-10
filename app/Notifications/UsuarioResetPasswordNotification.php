<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UsuarioResetPasswordNotification extends Notification
{
    use Queueable;

    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * Create a notification instance.
     */
    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
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
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject('Definir senha de primeiro acesso')
            ->greeting('Olá ' . ($notifiable->nome ?? ''))
            ->line('Você foi convidado(a) para acessar o Sistema Financeiro.')
            ->line('Para concluir o cadastro, defina sua senha de primeiro acesso clicando no botão abaixo.')
            ->action('Definir minha senha', $url)
            ->line('Se você não esperava este convite, pode simplesmente ignorar este e-mail.');
    }
}
