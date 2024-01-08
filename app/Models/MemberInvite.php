<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class MemberInvite extends Model
{
    use HasDateTimeFormatter;

    protected $table = 'member_invite';

    protected $fillable = [
        'invite_member_id',
        'member_id'
    ];
}
