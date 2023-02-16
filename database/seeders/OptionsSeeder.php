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
            ["option_name"=>"login_img","option_value"=>"hh.jpg"],
            ["option_name"=>"registration_img","option_value"=>"regg.jpg"],
            ["option_name"=>"registration_logo_img","option_value"=>"yy.png"],
            ["option_name"=>"verification_message","option_value"=>"<p>Hi,</p><p>&nbsp; &nbsp; &nbsp;Welcome to Our Organization. I hope you are happy to a part of our organiztion.</p>"],
            ["option_name"=>"inspector_request_assign_message","option_value"=>"<p>Hi [first_name],</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Your Request has been Successfully Assigned to [inspector_name].</p>"],
            ["option_name"=>"company_request_assign_message","option_value"=>"<p>Hi [first_name],</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Your [applicant_name] Request has been Successfully Assigned to [inspector_name].</p>"],
            ["option_name"=>"inspector_request_scheduled_message","option_value"=>"<p>Hi [first_name],</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Your Request has been Successfully Scheduled by [inspector_name].</p>"],
            ["option_name"=>"company_request_scheduled_message","option_value"=>"<p>Hi [first_name],</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Your [applicant_name] Request has been Successfully Scheduled on</p><p><font color='#2d3138' face='Open Sans, sans-serif'><span style='font-size: 1rem;'>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [inspection_date]<span style='font-size: 1rem;'>&nbsp;at&nbsp;</span></span></font><span style='color: rgb(45, 49, 56); font-family: &quot;Open Sans&quot;, sans-serif; font-size: 1rem;'>[inspection_time]<span style='font-size: 1rem;'>.</span></span></p><p><font color='#2d3138' face='Open Sans, sans-serif'><span style='font-size: 1rem;'>Inspector name -:&nbsp;</span>[inspector_name]</font></p><p><font color='#2d3138' face='Open Sans, sans-serif'>Company name -:&nbsp;[company_name]</font></p><p><span style='color: rgb(45, 49, 56); font-family: &quot;Open Sans&quot;, sans-serif; font-size: 1rem;'>Company location -:&nbsp;</span><font color='#2d3138' face='Open Sans, sans-serif'>[company_location]</font></p>"],
            ["option_name"=>"inspector_request_underreview_message","option_value"=>"<p>Hi [first_name],</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Your Request has been Successfully Reviewed By [inspector_name].</p>"],
            ["option_name"=>"company_request_underreview_message","option_value"=>"<p>Hi [first_name],</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Your Request has been Successfully Reviewed By [inspector_name].</p>"],
            ["option_name"=>"inspector_request_completed_message","option_value"=>"<p>Hi [first_name],</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Your Inspestion Request has been Successfully Completed.</p>"],
            ["option_name"=>"company_request_completed_message","option_value"=>"<p>Hi [first_name],</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Your Inspestion Request has been Successfully Completed.</p>"],
            ["option_name"=>"inspectorrequestreminderemail_message","option_value"=>"<p>Hi [inspector_name],</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Reminder for&nbsp;<span style='color: rgb(45, 49, 56); font-family: &quot;Open Sans&quot;, sans-serif; font-size: 1rem;'>an inspection with</span><span style='font-size: 1rem;'>&nbsp;[company_name]&nbsp; on&nbsp;</span></p><p><span style='font-size: 1rem;'>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;[inspection_date] at&nbsp;&nbsp;</span><span style='font-size: 1rem;'>[inspection_time].</span><span style='font-size: 1rem;'>&nbsp;&nbsp;</span></p><p><span style='font-size: 1rem;'>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Company Location -:&nbsp;</span>[company_location]</p>"],
            ["option_name"=>"companyrequestreminderemail_message","option_value"=>"<p>Hi [company_name],</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<font color='#2d3138' face='Open Sans, sans-serif'><span style='font-size: 1rem;'>As a reminder, your inspection is booked for [</span>inspection_date]<span style='font-size: 1rem;'>&nbsp;at&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</span></font><span style='color: rgb(45, 49, 56); font-family: &quot;Open Sans&quot;, sans-serif; font-size: 1rem;'>[</span><font color='#2d3138' face='Open Sans, sans-serif'>inspection_time]<span style='font-size: 1rem;'>.</span></font></p><p><font color='#2d3138' face='Open Sans, sans-serif'><span style='font-size: 1rem;'>Inspector name -:&nbsp;</span>[inspector_name]</font></p><p><font color='#2d3138' face='Open Sans, sans-serif'>Company name -:&nbsp;[company_name]</font></p><p><span style='color: rgb(45, 49, 56); font-family: &quot;Open Sans&quot;, sans-serif; font-size: 1rem;'>Company location -:&nbsp;</span><font color='#2d3138' face='Open Sans, sans-serif'>[company_location]</font></p>"]
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
