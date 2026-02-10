<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UsuarioInitialPasswordNotification extends Notification
{
    use Queueable;

    /**
     * The generated initial password.
     *
     * @var string
     */
    public $password;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $password)
    {
        $this->password = $password;
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
        return (new MailMessage)
            ->subject('Acesso ao Sistema Financeiro')
            ->greeting('Olá ' . ($notifiable->nome ?? ''))
            ->line('Seu usuário foi criado no Sistema Financeiro.')
            ->line('Dados de acesso:')
            ->line('E-mail: ' . $notifiable->email)
            ->line('Senha provisória: ' . $this->password)
            ->line('Por segurança, altere sua senha após o primeiro acesso.');
    }
}
