<?php

namespace App\Notifications;

use App\Models\KunjunganMember;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CheckInNotification extends Notification
{
    use Queueable;

    // private $kunjungan;
    /**
     * Create a new notification instance.
     */
    public function __construct(public KunjunganMember $kunjungan)
    {
        // $this->kunjungan =  $kunjungan;
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
    public function toMail($notifiable)
    {
        // dd($this->kunjungan);
        return (new MailMessage)
            ->subject('Successfully Daily Checkin - '.env('APP_NAME', 'Natural Fitness Center'))
            ->view(
                'templates.pages.kunjungan.email-checkin',
                [
                    'kunjungan' => $this->kunjungan,
                    'date' => Carbon::parse($this->kunjungan->kunjungan->datein)->format('d F Y'),
                    'time' => Carbon::parse($this->kunjungan->checkin_time)->format('H:i:s'),
                ]
            );
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
}
