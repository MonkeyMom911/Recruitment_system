<?php
namespace App\Notifications;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewApplicationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $application;

    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $applicant = $this->application->user;
        $jobVacancy = $this->application->jobVacancy;

        return (new MailMessage)
            ->subject('New Application Received - ' . $jobVacancy->title)
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('A new application has been submitted for the position of ' . $jobVacancy->title . '.')
            ->line('Applicant: ' . $applicant->name)
            ->line('Email: ' . $applicant->email)
            ->line('Submitted on: ' . $this->application->created_at->format('Y-m-d H:i'))
            ->action('View Application', url(route('hrd.applications.show', $this->application->id)))
            ->line('Please review the application at your earliest convenience.');
    }

    public function toArray($notifiable)
    {
        $applicant = $this->application->user;
        
        return [
            'application_id' => $this->application->id,
            'job_vacancy_id' => $this->application->job_vacancy_id,
            'job_title' => $this->application->jobVacancy->title,
            'applicant_name' => $applicant->name,
            'applicant_id' => $applicant->id,
            'message' => 'New application from ' . $applicant->name . ' for ' . $this->application->jobVacancy->title,
            'type' => 'new_application',
        ];
    }
}