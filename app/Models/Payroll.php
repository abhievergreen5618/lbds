<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_id',
        'ins_fee',
        'income',
        // 'pay_start',
        'pay_range_start',
        'pay_range_end',
        'pay_date',
        'payment_status'
    ];
}
