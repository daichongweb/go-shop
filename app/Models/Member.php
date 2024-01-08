<?php

namespace App\Models;

use App\Http\Services\MemberService;
use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Member extends Model
{
    use HasDateTimeFormatter, HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'mobile',
        'nickname',
        'password',
        'vip',
        'status',
        'remark',
        'channel_code'
    ];

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

    protected $hidden = [
        'password'
    ];

    protected static function booted()
    {
        static::creating(function ($user) {
            if (!$user->channel_code) {
                $user->channel_code = MemberService::genChannelCode();
            }
        });
    }
}
