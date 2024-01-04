<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class VipApply extends Model
{
    use HasDateTimeFormatter;

    protected $fillable = [
        'name',
        'mobile',
        'id_card',
        'remark',
        'status',
        'reject_message'
    ];

    protected $table = 'vip_apply';

    public const STATUS_WAIT = 0;

    public const STATUS_OK = 1;

    public const STATUS_CACHE = -1;

    public const STATUS_MAP = [
        self::STATUS_WAIT => '待审核',
        self::STATUS_OK => '已完成',
        self::STATUS_CACHE => '已驳回'
    ];

    public const STATUS_COLOR = [
        self::STATUS_WAIT => "green",
        self::STATUS_OK => "success",
        self::STATUS_CACHE => "red",
    ];

    public const TYPE_1 = 1;
    public const TYPE_2 = 2;

    public const TYPE_MAP = [
        self::TYPE_1 => '运营中心',
        self::TYPE_2 => '分销商',
    ];
}
