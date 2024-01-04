<?php

namespace App\Http\Services;

use App\Models\Member;

class MemberService
{
    public static function genChannelCode(): int
    {
        do {
            $code = rand(100000, 999999999);
            $exists = member::query()->where('channel_code', $code)->exists();
        } while ($exists);
        return $code;
    }
}
