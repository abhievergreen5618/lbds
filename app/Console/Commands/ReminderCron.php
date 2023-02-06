<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Carbon\Carbon;
use App\Models\RequestModel;
use Illuminate\Support\Facades\Mail;
use Exception;
use App\Models\User;
use App\Mail\Admin\ReminderMail;


class ReminderCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:cr';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        info("Cron Job running at ". now());
        $ldate = date('Y-m-d');
        $result = RequestModel::where('schedule_time', '!=', null)->where("scheduled_at",'>=',$ldate)->where("remindermailstatus","notsend")->get();
        foreach($result as $key => $value)
        {
            $to = Carbon::now();
            $from = Carbon::createFromFormat('Y-m-d H:s:i',$value['scheduled_at']." ".$value['schedule_time']);
            $diff_in_hours = $to->diffInHours($from);
            if($diff_in_hours <= 8)
            {
                try
                {
                    $insdetails = User::where(["id"=>$value['assigned_ins']])->first();
                    $companydetails = User::where(["id"=>$value['company_id']])->first();
                    Mail::to($companydetails['email'])->cc($requestdetails['applicantemail'])->send(new ReminderMail($insdetails,$companydetails,$value,"company"));
                    Mail::to($insdetails['email'])->send(new ReminderMail($insdetails,$companydetails,$value,"inspector"));
                    RequestModel::where(["id"=>$value['id']])->update([
                        "remindermailstatus" => "sent",
                    ]);
                }
                catch(Expection $e)
                {
                    RequestModel::where(["id"=>$value['id']])->update([
                        "remindermailstatus" => "notsend",
                    ]);
                }
                
            }  
        }
        return Command::SUCCESS;
    }
}
