<?php

namespace App\Mail\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;

class Report extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $files;
    public $message;

    public function __construct($data)
    {
        $this->subject = $data['subject'];
        $this->files = (isset($data['attachments']) ? $data['attachments'] : NULL);
        $this->message = $data['message'];
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            markdown: 'admin.request.mail.reportemail',
            with: [
                'message' => $this->message,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        $data = [];
        if (!empty($this->files)) {
            foreach ($this->files as $key => $value) {
                $value = asset('taskfiles/' .rawurlencode($value));
                $data[] = Attachment::fromPath($value);
            }
        }
        return $data;
    }
}
