<?php

namespace App\Mail;

use App\Models\KunjunganMember;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CheckIn extends Mailable
{
    use Queueable, SerializesModels;

    // private $to;
    /**
     * Create a new message instance.
     */
    public function __construct(public KunjunganMember $kunjungan)
    {
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Successfully Daily Checkin - '.env('APP_NAME', 'Natural Fitness Center'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'templates.pages.kunjungan.email-checkin',
            with: [
                'kunjungan' => $this->kunjungan,
                'date' => Carbon::parse($this->kunjungan->kunjungan->datein)->format('d F Y'),
                'time' => Carbon::parse($this->kunjungan->checkin_time)->format('H:i:s'),
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
