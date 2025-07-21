<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewUserRegisteredNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public User $newUser;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $newUser)  
    {
        $this->newUser = $newUser;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // Kirim ke database (untuk ikon lonceng) dan email
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('New User Registration')
                    ->greeting('Hello ' . $notifiable->name . ',')
                    ->line('A new user has just registered on the platform.')
                    ->line('Name: ' . $this->newUser->name)
                    ->line('Email: ' . $this->newUser->email)
                    ->action('View User Details', route('admin.users.show', $this->newUser->id))
                    ->line('You can manage the new user from the admin dashboard.');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'new_user_id' => $this->newUser->id,
            'new_user_name' => $this->newUser->name,
            'message' => 'A new user has registered: ' . $this->newUser->name,
            'type' => 'new_user_registered',
        ];
    }
}