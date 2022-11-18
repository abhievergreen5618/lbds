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
        'mailcc',
        'mailbcc',
        'subject',
        'message',
        'files',
        'attachments',
        'status',
    ];

    protected $casts = [
        "mailto" => "array",
        "mailcc" => "array",
        "mailbcc" => "array",
        "attachments" => "array",
    ];


    public function saveemail($data,$status)
    {
        EmailModel::Create(
            [
                "requestid"   =>  $data['requestid'],
                "mailto"      =>  (isset($data['reportmailto']) ? $data['reportmailto'] : NULL),
                "mailcc"      =>  (isset($data['reportmailcc']) ? $data['reportmailcc'] : NULL),
                "mailbcc"     =>  (isset($data['reportmailbcc']) ? $data['reportmailbcc'] : NULL),
                "subject"     =>  (isset($data['subject']) ? $data['subject'] : NULL),
                "message"     =>  (isset($data['message']) ? $data['message'] : NULL),
                "files"       =>  (isset($data['files']) ? $data['files'] : NULL),
                "attachments" =>  (isset($data['attachments']) ? $data['attachments'] : NULL),
                "status"      =>   $status,
            ],
        );
    }
    public function saveemaildraft($data,$status)
    {
        EmailModel::updateOrCreate(
            [
                "requestid"=>$data['requestid'],
                "status" => "draft",
            ],
            [
                "mailto"      =>  (isset($data['reportmailto']) ? $data['reportmailto'] : NULL),
                "mailcc"      =>  (isset($data['reportmailcc']) ? $data['reportmailcc'] : NULL),
                "mailbcc"     =>  (isset($data['reportmailbcc']) ? $data['reportmailbcc'] : NULL),
                "subject"     =>  (isset($data['subject']) ? $data['subject'] : NULL),
                "message"     =>  (isset($data['message']) ? $data['message'] : NULL),
                "files"       =>  (isset($data['files']) ? $data['files'] : NULL),
                "attachments" =>  (isset($data['attachments']) ? $data['attachments'] : NULL),
                "status"      =>   $status,
            ],
        );
    }
}
