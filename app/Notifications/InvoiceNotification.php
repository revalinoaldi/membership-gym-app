<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Session;

class InvoiceNotification extends Notification
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
    public function toMail(object $notifiable)
    {
        $token = Session::get('token');
        $token = base64_encode(base64_encode($token));
        $urlView = url('transaksi/payment')."/{$this->transaksi->kode_transaksi}?token={$token}";

        return (new MailMessage)
            ->subject('Konfirmasi Pembayaran - '.env('APP_NAME', 'Natural Fitness Center'))
            ->view(
                'templates.pages.transaksi.notifikasi.billpayment',
                [
                    'transaksi'     => $this->transaksi,
                    'date'          => date('d/m/Y'),
                    'url'           => $urlView
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
