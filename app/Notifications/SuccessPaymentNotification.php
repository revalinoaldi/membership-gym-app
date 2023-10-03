<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Session;

class SuccessPaymentNotification extends Notification
{
    use Queueable;

    private $transaksi;
    /**
     * Create a new notification instance.
     */
    public function __construct($transaksi)
    {
        $this->transaksi = $transaksi;
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
        $token = Session::get('token');
        $token = base64_encode(base64_encode($token));
        $urlView = url('transaksi')."/{$this->transaksi->kode_transaksi}?token={$token}";
        return (new MailMessage)
            ->subject('Terima kasih atas pembayaran Anda - '.env('APP_NAME', 'Natural Fitness Center'))
            ->view(
                'templates.pages.transaksi.notifikasi.success',
                [
                    'transaksi'     => $this->transaksi,
                    'date'      => date('d/m/Y'),
                    'url' => $urlView
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
