<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CodeMail extends Mailable
{
    use Queueable, SerializesModels;

    protected string $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    /**
     * @return Envelope
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject:'Code Mail',
        );
    }

    /**
     * @return Content
     */
    public function content(): Content
    {
        return new Content(htmlString:$this->getHtmlContent());
    }

    /**
     * @return string
     */
    private function getHtmlContent(): string
    {
        return "
            <html>
                <body>
                    <h1>$this->message</h1>
                </body>
            </html>
        ";
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
