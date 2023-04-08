<?php

namespace Lumis\LeaveApplication\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Lumis\LeaveApplication\Entities\Leave;

class LeaveActivatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var Leave
     */
    public Leave $leave;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Leave $leave)
    {
        $this->leave = $leave;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->markdown('leaveapplication::emails.leave_activated_notification', [
                'leave' => $this->leave
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
