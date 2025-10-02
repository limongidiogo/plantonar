<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Plantao; // Importa o Model Plantao

class MedicoAprovadoNotification extends Notification
{
    use Queueable;

    public $plantao; // Propriedade pública para armazenar o plantão

    /**
     * Create a new notification instance.
     */
    public function __construct(Plantao $plantao)
    {
        $this->plantao = $plantao;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // Vamos salvar apenas no banco de dados por enquanto
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        // Este é o array de dados que será salvo como um JSON na tabela 'notifications'
        return [
            'plantao_id' => $this->plantao->id,
            'message' => 'Parabéns! Você foi aprovado para o plantão de ' . $this->plantao->specialty . ' no dia ' . \Carbon\Carbon::parse($this->plantao->date)->format('d/m/Y') . '.',
            'url' => route('profile.candidacies'), // URL para onde o usuário será levado ao clicar
        ];
    }
}

