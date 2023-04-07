<?php

namespace Lumis\LeaveApplication\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Lumis\StaffManagement\Entities\Staff;
use Lumis\LeaveApplication\Entities\Leave;

class LeaveApprovedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var Leave
     */
    public Leave $leave;

    /**
     * @var Staff
     */
    public Staff $staff;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Leave $leave, Staff $staff)
    {
        $this->leave = $leave;
        $this->staff = $staff;
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
            ->markdown('leavemanagement::emails.leave_approved_notification', [
                'leave' => $this->leave,
                'staff' => $this->staff
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
