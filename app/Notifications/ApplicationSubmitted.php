<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApplicationSubmitted extends Notification implements ShouldQueue
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
        $jobVacancy = $this->application->jobVacancy;

        return (new MailMessage)
            ->subject('Application Submitted - ' . $jobVacancy->title)
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Thank you for submitting your application for the position of ' . $jobVacancy->title . '.')
            ->line('Your application has been received and is currently under review.')
            ->line('You can check the status of your application anytime by logging into your account.')
            ->action('View Application', url(route('applicant.applications.show', $this->application->id)))
            ->line('Thank you for your interest in joining our team!')
            ->line('We will contact you soon regarding the next steps.');
    }

    public function toArray($notifiable)
    {
        return [
            'application_id' => $this->application->id,
            'job_vacancy_id' => $this->application->job_vacancy_id,
            'job_title' => $this->application->jobVacancy->title,
            'status' => $this->application->status,
            'message' => 'Your application has been submitted successfully.',
            'type' => 'application_submitted',
        ];
    }
}