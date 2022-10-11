<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    ];

    protected $casts = [
        "inspectiontype" => "array",
        "sendinvoice" => "array",
        'agency_related_files' => 'array',
        'reports_related_files' => 'array',
    ];
}
