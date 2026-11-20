<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AZMediaEmail extends Mailable
{
    use Queueable, SerializesModels;

    public string $emailSubject;
    public string $bodyHtml;
    public string $recipientName;

    /**
     * Create a new message instance.
     */
    public function __construct(string $subject, string $bodyHtml, string $recipientName)
    {
        $this->emailSubject = $subject;
        $this->bodyHtml     = $bodyHtml;
        $this->recipientName = $recipientName;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this
            ->subject($this->emailSubject)
            ->from(config('mail.from.address'), 'AZ Media - Ban Tuyển Dụng')
            ->view('emails.azmedia_email');
    }
}
