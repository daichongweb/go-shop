<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Response\Rsp;
use App\Models\Member;
use App\Models\MemberInvite;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class MemberController extends Controller
{
    public function getParent(Request $request): JsonResponse
    {
        $invite = MemberInvite::query()->where('member_id', $request->user()->id)->value('invite_member_id');
        if (!$invite) {
            return Rsp::success(null);
        }
        return Rsp::success(Member::query()->find($invite));
    }

    /**
     * @throws ApiException
     */
    public function bind(Request $request): JsonResponse
    {
        $inviteMember = Member::query()->where('channel_code', $request->post('channel_code'))->first();
        if (!$inviteMember) {
            throw new ApiException('邀请码无效');
        }
        $memberId = $request->user()->id;
        $invite = MemberInvite::query()->where('member_id', $memberId)->where('invite_member_id', $inviteMember->id)->exists();
        if ($invite) {
            throw new ApiException('邀请关系已存在');
        }
        $inviteModel = new MemberInvite([
            'member_id' => $memberId,
            'invite_member_id' => $inviteMember->id
        ]);
        if (!$inviteModel->save()) {
            throw new ApiException('绑定失败');
        }
        return Rsp::success();
    }
}
