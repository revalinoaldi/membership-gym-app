<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Session;

class SuccessPayment extends Mailable
{
    use Queueable, SerializesModels;

    private $transaksi;
    /**
     * Create a new message instance.
     */
    public function __construct($transaksi)
    {
        $this->transaksi = $transaksi;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Terima kasih atas pembayaran Anda - '.env('APP_NAME', 'Natural Fitness Center'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $token = Session::get('token');
        $token = base64_encode(base64_encode($token));
        $urlView = url('transaksi')."/{$this->transaksi->kode_transaksi}?token={$token}";

        return new Content(
            view: 'templates.pages.transaksi.notifikasi.success',
            with: [
                'transaksi'     => $this->transaksi,
                'date'      => date('d/m/Y'),
                'url' => $urlView
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
