<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasDateTimeFormatter;

    protected $fillable = [
        'member_id',
        'pay_member_id',
        'reference_member_id',
        'product_id',
        'pay_price',
        'num',
        'status'
    ];

    public const STATUS_WAIT = 0;

    public const STATUS_OK = 1;

    public const STATUS_CACHE = -1;

    public const STATUS_MAP = [
        self::STATUS_WAIT => '待支付',
        self::STATUS_OK => '已完成',
        self::STATUS_CACHE => '已取消'
    ];

    public const STATUS_COLOR = [
        self::STATUS_WAIT => "green",
        self::STATUS_OK => "success",
        self::STATUS_CACHE => "red",
    ];

    public function member(): HasOne
    {
        return $this->hasOne(Member::class, 'id', 'member_id');
    }

    public function payMember(): HasOne
    {
        return $this->hasOne(Member::class, 'id', 'pay_member_id');
    }

    public function referenceMember(): HasOne
    {
        return $this->hasOne(Member::class, 'id', 'reference_member_id');
    }

    public function product(): HasOne
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
