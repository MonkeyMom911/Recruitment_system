<?php
namespace App\Notifications;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApplicationStatusUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    public $application;
    public $oldStatus;

    public function __construct(Application $application, $oldStatus)
    {
        $this->application = $application;
        $this->oldStatus = $oldStatus;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $jobVacancy = $this->application->jobVacancy;
        $status = ucfirst($this->application->status);
        
        $message = (new MailMessage)
            ->subject('Application Status Updated - ' . $jobVacancy->title)
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Your application status for the position of ' . $jobVacancy->title . ' has been updated.')
            ->line('Status: ' . $status);

        if ($this->application->status === 'hired') {
            $message->line('Congratulations! You have been selected for the position.')
                   ->line('We will contact you shortly with more details about the next steps.');
        } elseif ($this->application->status === 'rejected') {
            $message->line('We appreciate your interest in joining our team.')
                   ->line('After careful consideration, we have decided to move forward with other candidates whose qualifications better align with our current needs.');
        } else {
            $message->line('Your application is progressing through our selection process.');
        }

        $message->action('View Application Details', url(route('applicant.applications.show', $this->application->id)))
               ->line('Thank you for your interest in joining our team!');

        return $message;
    }

    public function toArray($notifiable)
    {
        return [
            'application_id' => $this->application->id,
            'job_vacancy_id' => $this->application->job_vacancy_id,
            'job_title' => $this->application->jobVacancy->title,
            'old_status' => $this->oldStatus,
            'new_status' => $this->application->status,
            'message' => 'Your application status has been updated to "' . ucfirst($this->application->status) . '"',
            'type' => 'status_updated',
        ];
    }
}