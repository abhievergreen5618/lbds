<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;


class RequestModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'inspectiontype',
        'applicantname',
        'applicantemail',
        'applicantmobile',
        'address',
        'city',
        'state',
        'zipcode',
        'sendinvoice',
        'comments',
        'status',
        'agency_related_files',
        'reports_related_files',
        'assigned_ins',
        'assigned_at',
        'ins_fee',
        'scheduled_at',
        'schedule_time',
        'underreview_at',
        'cancel_reason',
        'completed_at',
        'inspectorcomments',
        'agencycomments',
        'invoice',
        'requestnote',
        'remindermailstatus',
        'pay_range_start',
        'pay_range_end',
        'custom_created_at',
        'cancelled_by',
        'unique_request_id',
    ];

    protected $casts = [
        "inspectiontype" => "array",
        "sendinvoice" => "array",
        'agency_related_files' => 'array',
        'reports_related_files' => 'array',
    ];

    public function unique_request_id($randnumber = 0)
    {
        $prefix = 'REQ_';
        $time = date('His');
        $randnumber = ($randnumber == 0) ? rand(1,9) : "";
        $uniqueId = $prefix.$time.$randnumber;
        $count = RequestModel::where("unique_request_id",$uniqueId)->count();
        if($count == 0)
        {
            return $uniqueId;
        }
        else
        {
            $uniqueId = $this->unique_request_id(rand(1,9));
            return $uniqueId;
        }
    }
}
