<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsCode extends Model
{
    protected $table = 'sms_code';

    protected $fillable = [
        'mobile',
        'status',
        'code'
    ];

    public const STATUS_WAIT = 0;

    public const STATUS_USED = 1;

    public const STATUS_EXPIRE = -1;
}
