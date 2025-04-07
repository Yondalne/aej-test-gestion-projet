<?php

namespace App\Notifications;

use App\Models\Projet;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProjetStatusNotification extends Notification
{
    use Queueable;

    protected $projet;

    /**
     * Create a new notification instance.
     */
    public function __construct(Projet $projet)
    {
        $this->projet = $projet;
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
        if ($this->projet->statut === 'En Attente') {
            return (new MailMessage)
                ->subject($this->getSubject())
                ->view('emails.projet-create', [
                    'projet' => $this->projet,
                    'notifiable' => $notifiable
                ]);
        }else {
            return (new MailMessage)
                ->subject($this->getSubject())
                ->view('emails.projets-status-update', [
                    'projet' => $this->projet,
                    'notifiable' => $notifiable
                ]);
        }
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

    private function getSubject(): string
    {
        if ($this->projet->statut === 'Validé') {
            return 'Bonne nouvelle! Votre projet a été validé';
        } else if ($this->projet->statut === 'Rejeté') {
            return 'Information concernant votre projet';
        }

        return 'Mise à jour du statut de votre projet';
    }
}
