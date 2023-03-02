<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Options;

class OptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $options = [
            ["option_name"=>"website_logo","option_value"=>"logo.png"],
            ["option_name"=>"website_second_logo","option_value"=>"lg.png"],
            ["option_name"=>"app_name","option_value"=>"WindMitigation.network"],
            ["option_name"=>"website_email","option_value"=>"admin@windmitigations.com"],
            ["option_name"=>"mail_host","option_value"=>"mail.lbdstestdomain.com"],
            ["option_name"=>"mail_port","option_value"=>"465"],
            ["option_name"=>"mail_username","option_value"=>"wind@lbdstestdomain.com"],
            ["option_name"=>"mail_password","option_value"=>"%T(aSwMaB1Wv"],
            ["option_name"=>"mail_from_address","option_value"=>"wind@lbdstestdomain.com"],
            ["option_name"=>"mail_encryption","option_value"=>"tls"],
            ["option_name"=>"pusher_app_id","option_value"=>"1491874"],
            ["option_name"=>"pusher_app_key","option_value"=>"cdb5dfb1da13d59428cd"],
            ["option_name"=>"pusher_app_secret","option_value"=>"183916ae7c51fb45a86b"],
            ["option_name"=>"pusher_app_cluster","option_value"=>"us3"],
            ["option_name"=>"login_img","option_value"=>"loginimage.jpg"],
            ["option_name"=>"registration_img","option_value"=>"regg.jpg"],
            ["option_name"=>"registration_logo_img","option_value"=>"yy.png"],
            ["option_name"=>"verification_message","option_value"=>"<p>Hi,</p><p>Welcome to Our Organization. I hope you are happy to a part of our organization.</p>"],
            ["option_name"=>"inspector_request_assign_message","option_value"=>"<p>Hi [first_name],</p><p>Your Request has been Successfully Assigned to [inspector_name].</p>"],
            ["option_name"=>"company_request_assign_message","option_value"=>"<p>Hi [first_name],</p><p>Your [applicant_name] Request has been Successfully Assigned to [inspector_name].</p>"],
            ["option_name"=>"inspector_request_scheduled_message","option_value"=>"<p>Hi [first_name],</p><p>Your Request has been Successfully Scheduled by [inspector_name].</p>"],
            ["option_name"=>"company_request_scheduled_message","option_value"=>"<p>Hi [first_name],</p><p>Your [applicant_name] Request has been Successfully Scheduled on [inspection_date] at [inspection_time]</p><p>Inspector name -: [inspector_name]</p><p>Company name -: [company_name]</p><p>Company location -:&nbsp;[company_location]</p>"],
            ["option_name"=>"inspector_request_underreview_message","option_value"=>"<p>Hi [first_name],</p><p>Your Request has been Successfully Reviewed By [inspector_name].</p>"],
            ["option_name"=>"company_request_underreview_message","option_value"=>"<p>Hi [first_name],</p><p>Your Request has been Successfully Reviewed By [inspector_name].</p>"],
            ["option_name"=>"inspector_request_completed_message","option_value"=>"<p>Hi [first_name],</p><p>Your Inspestion Request has been Successfully Completed.</p>"],
            ["option_name"=>"company_request_completed_message","option_value"=>"<p>Hi [first_name],</p><p>Your Inspestion Request has been Successfully Completed.</p>"],
            ["option_name"=>"inspectorrequestreminderemail_message","option_value"=>"<p>Hi [inspector_name],</p><p>Reminder for an inspection with [company_name] on [inspection_date] at [inspection_time].<p>Inspector name -: [inspector_name]</p><p>Company name -: [company_name]</p><p>Company location -: [company_location]</p>"],
            ["option_name"=>"companyrequestreminderemail_message","option_value"=>"<p>Hi [company_name],</p><p>As a reminder, your inspection is booked for [inspection_date] at [inspection_time].<p>Inspector name -: [inspector_name]</p><p>Company name -: [company_name]</p><p>Company location -: [company_location]</p>"]
        ];

        foreach($options as $key => $value)
        {
            Options::create([
                "option_name" =>  $value['option_name'],
                "option_value" => $value['option_value'],
            ]);
        }

    }
}
