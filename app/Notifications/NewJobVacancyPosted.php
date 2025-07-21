<?php

namespace App\Notifications;

use App\Models\JobVacancy;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewJobVacancyPosted extends Notification implements ShouldQueue
{
    use Queueable;

    public JobVacancy $jobVacancy;

    /**
     * Create a new notification instance.
     */
    public function __construct(JobVacancy $jobVacancy)
    {
        $this->jobVacancy = $jobVacancy;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail']; // Kirim ke database (ikon lonceng) dan email
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $creatorName = $this->jobVacancy->creator->name;

        return (new MailMessage)
                    ->subject('New Job Vacancy Posted: ' . $this->jobVacancy->title)
                    ->greeting('Hello, Admin!')
                    ->line('A new job vacancy has been posted by ' . $creatorName . '.')
                    ->line('Title: ' . $this->jobVacancy->title)
                    ->line('Department: ' . $this->jobVacancy->department)
                    ->action('View Job Vacancy', route('admin.job-vacancies.show', $this->jobVacancy->id))
                    ->line('Please review it at your convenience.');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'job_vacancy_id' => $this->jobVacancy->id,
            'job_vacancy_title' => $this->jobVacancy->title,
            'creator_id' => $this->jobVacancy->creator->id,
            'creator_name' => $this->jobVacancy->creator->name,
            'message' => 'New job vacancy posted by ' . $this->jobVacancy->creator->name . ': "' . $this->jobVacancy->title . '"',
            'type' => 'new_job_vacancy',
        ];
    }
}