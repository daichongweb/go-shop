<?php

namespace App\Jobs;

use App\Models\Member;
use App\Models\MemberInvite;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class BindChannelCodeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $memberId;

    protected int $channelCode;

    /**
     * Create a new job instance.
     */
    public function __construct($memberId, $channelCode)
    {
        $this->memberId = $memberId;
        $this->channelCode = $channelCode;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $inviteMember = Member::query()->where('channel_code', $this->channelCode)->first();
        if (!$inviteMember) {
            Log::error(sprintf('邀请关系绑定失败：channelCoode:【%s】,用户：【%s】', $this->channelCode, $this->memberId));
        }
        $invite = MemberInvite::query()->where('member_id', $this->memberId)->where('invite_member_id', $inviteMember->id)->exists();
        if ($invite) {
            Log::error(sprintf('邀请关系已存在：channelCoode:【%s】,用户：【%s】', $this->channelCode, $this->memberId));
        }
        $inviteModel = new MemberInvite([
            'member_id' => $this->memberId,
            'invite_member_id' => $inviteMember->id
        ]);
        if (!$inviteModel->save()) {
            Log::error(sprintf('邀请关系绑定失败：channelCoode:【%s】,用户：【%s】', $this->channelCode, $this->memberId));
        }
    }
}
