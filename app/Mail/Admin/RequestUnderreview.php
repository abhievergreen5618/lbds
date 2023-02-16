<?php

namespace App\Mail\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Options;
class RequestUnderreview extends Mailable
{
    use Queueable, SerializesModels;

    public $insdetails;
    public $companydetails;
    public $requestdetails;
    public $type;

    public function __construct($insdetails,$companydetails,$requestdetails,$subject,$type)
    {
        $options=new Options();
        $this->insdetails = $insdetails;
        $this->companydetails = $companydetails;
        $this->requestdetails = $requestdetails;
        $this->subject=$subject;
        $this->body= $options->get_option('requestunderreview_message');    
        if($type=='inspectorassign')
        {
            $this->body= str_replace('[first_name]',$insdetails->name,$this->body);
            $this->body= str_replace('[inspector_name]',$insdetails->name,$this->body);
            $this->body= str_replace('[company_name]',$companydetails->company_name,$this->body);
            $this->body= str_replace('[company_location]',$companydetails->company_address,$this->body);
        }
        else{
            $this->body= str_replace('[first_name]',$companydetails->name,$this->body);
            $this->body= str_replace('[inspector_name]',$insdetails->name,$this->body);
            $this->body= str_replace('[company_name]',$companydetails->company_name,$this->body);
            $this->body= str_replace('[company_location]',$companydetails->company_address,$this->body);
            $this->body= str_replace('[applicant_name]',$requestdetails['applicantname'],$this->body);
            $this->body= str_replace('[applicant_email]',$requestdetail['applicantemail'],$this->body);
        }

    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        // dd($this->subject);
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
            markdown: 'admin.inspector.mail.assign',
            with: [
                'insdetails'=>$this->insdetails,
                'companydetails'=>$this->companydetails,
                'requestdetails'=>$this->requestdetails,
                'subject'=>$this->subject,
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
