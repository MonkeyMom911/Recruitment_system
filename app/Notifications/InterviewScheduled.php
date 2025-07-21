<?php
namespace App\Notifications;

use App\Models\ApplicationStage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InterviewScheduled extends Notification implements ShouldQueue
{
    use Queueable;

    public $applicationStage;

    public function __construct(ApplicationStage $applicationStage)
    {
        $this->applicationStage = $applicationStage;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $application = $this->applicationStage->application;
        $jobVacancy = $application->jobVacancy;
        $stageName = $this->applicationStage->selectionStage->name;
        $scheduledDate = $this->applicationStage->scheduled_date->format('l, F j, Y \a\t g:i A');
        
        return (new MailMessage)
            ->subject($stageName . ' Scheduled - ' . $jobVacancy->title)
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('We are pleased to inform you that your ' . strtolower($stageName) . ' for the position of ' . $jobVacancy->title . ' has been scheduled.')
            ->line('Date and Time: ' . $scheduledDate)
            ->line('Please make sure to be prepared and available at the scheduled time.')
            ->lineIf($this->applicationStage->notes, 'Additional Notes: ' . $this->applicationStage->notes)
            ->action('View Application Details', url(route('applicant.applications.show', $application->id)))
            ->line('If you have any questions or need to reschedule, please contact us as soon as possible.')
            ->line('Thank you for your interest in joining our team!');
    }

    public function toArray($notifiable)
    {
        $application = $this->applicationStage->application;
        $stageName = $this->applicationStage->selectionStage->name;
        
        return [
            'application_id' => $application->id,
            'job_vacancy_id' => $application->job_vacancy_id,
            'job_title' => $application->jobVacancy->title,
            'stage_id' => $this->applicationStage->id,
            'stage_name' => $stageName,
            'scheduled_date' => $this->applicationStage->scheduled_date->format('Y-m-d H:i:s'),
            'message' => $stageName . ' has been scheduled for ' . $this->applicationStage->scheduled_date->format('l, F j, Y \a\t g:i A'),
            'type' => 'interview_scheduled',
        ];
    }
}