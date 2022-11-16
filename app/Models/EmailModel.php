<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'requestid',
        'mailto',
        'subject',
        'message',
        'files',
        'attachments',
        'status',
    ];

    protected $casts = [
        "mailto" => "array",
        "attachments" => "array",
    ];


    public function saveemail($data,$status)
    {
        EmailModel::updateOrCreate(
            [
                "requestid"=>$data['requestid'],
                "status" => "draft",
            ],
            [
                "mailto"=>$data['reportmailto'],
                "subject"=>$data['subject'],
                "message"=>$data['message'],
                "files"=>$data['files'],
                "attachments"=>$data['attachments'],
                "status"=>$status,
            ],
        );
    }
    public function saveemaildraft($data,$status)
    {
        EmailModel::updateOrCreate(
            ["requestid"=>$data['requestid']],
            [
                "mailto"=>$data['reportmailto'],
                "subject"=>$data['subject'],
                "message"=>$data['message'],
                "files"=>$data['files'],
                "attachments"=>$data['attachments'],
                "status"=>$status,
            ],
        );
    }
}
