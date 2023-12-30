<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasDateTimeFormatter;

    public const STATUS_OK = 1;

    public const STATUS_DISABLE = 0;

    public const STATUS_MAP = [
        self::STATUS_OK => '启用',
        self::STATUS_DISABLE => '禁用'
    ];

    public const VIP_MAP = [
        0, 1, 2, 3
    ];

    protected function remark(): Attribute
    {
        return new Attribute(
            get: fn($value) => $value,
            set: fn($value) => $value ?: '',
        );
    }
}