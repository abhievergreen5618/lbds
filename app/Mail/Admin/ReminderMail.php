<?php

namespace App\Mail\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Options;

class ReminderMail extends Mailable
{
    use Queueable, SerializesModels;
    public $insdetails;
    public $companydetails;
    public $requestdetails;
    public $senduser;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($insdetails,$companydetails,$requestdetails,$senduser)
    {
        $options=new Options();
        $this->body= ($senduser == "company") ? $options->get_option('companyrequestreminderemail_message') : $options->get_option('inspectorrequestreminderemail_message') ; 
        $this->body= str_replace('[inspector_name]',$insdetails->name,$this->body);
        $this->body= str_replace('[company_name]',$companydetails->company_name,$this->body);
        $this->body= str_replace('[company_location]',$companydetails->company_address,$this->body);
        $this->body= str_replace('[inspection_date]',$requestdetails['scheduled_at'],$this->body);
        $this->body= str_replace('[inspection_time]',$requestdetails['schedule_time'],$this->body);
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Reminder Mail',
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
            markdown: 'emails.reminderemail',
            with: [
                'body' => $this->body,
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
        return [];
    }
}
