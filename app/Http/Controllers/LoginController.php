<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\SmsCodeRequest;
use App\Http\Requests\SmsLoginRequest;
use App\Http\Response\Rsp;
use App\Http\Utils\StringUtil;
use App\Jobs\BindChannelCodeJob;
use App\Models\Member;
use App\Models\SmsCode;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * @throws ApiException
     */
    public function index(Request $request): JsonResponse
    {
        $mobile = $request->post('mobile');
        $password = $request->post('password');
        if (!$mobile || !$password) {
            throw new ApiException('缺少参数');
        }
        $member = Member::query()->where('mobile', $mobile)->first();
        if (!$member) {
            throw new ApiException('用户不存在');
        }
        if (!password_verify($password, $member->password)) {
            throw new ApiException('密码错误');
        }
        return Rsp::success([
            'member' => $member,
            'token' => $member->createToken($mobile)->plainTextToken,
        ]);
    }

    /**
     * @throws ApiException
     */
    public function reg(Request $request): JsonResponse
    {
        $mobile = $request->post('mobile');
        $password = $request->post('password');
        if (!$mobile || !$password) {
            throw new ApiException('缺少参数');
        }
        $member = Member::query()->where('mobile', $mobile)->first();
        if ($member) {
            throw new ApiException('用户已注册');
        }
        $member = new Member([
            'mobile' => $mobile,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'nickname' => $request->post('nickname', ''),
            'vip' => 0
        ]);
        if (!$member->save()) {
            throw new ApiException('注册失败');
        }
        return Rsp::success();
    }

    /**
     * @throws ApiException
     */
    public function genSmsCode(SmsCodeRequest $request): JsonResponse
    {
        $request->validated();
        $code = rand(100000, 999999);
        $model = new SmsCode([
            'mobile' => $request->post('mobile'),
            'code' => $code,
            'status' => 0
        ]);
        if (!$model->save()) {
            throw new ApiException('验证码发送失败');
        }
        return Rsp::success([
            'code' => $code,
        ]);
    }

    /**
     * @throws ApiException
     */
    public function smsLogin(SmsLoginRequest $request): JsonResponse
    {
        $request->validated();
        $mobile = $request->post('mobile');
        $smsCode = SmsCode::query()->where('mobile', $mobile)->where('code', $request->post('code'))->first();
        if (!$smsCode) {
            throw new ApiException('验证码无效');
        }
        if ($smsCode->status != SmsCode::STATUS_WAIT) {
            throw new ApiException('验证码已失效');
        }
        $smsCode->status = SmsCode::STATUS_USED;
        $smsCode->save();

        $member = Member::query()->where('mobile', $mobile)->first();
        if (!$member) {
            $member = new Member([
                'mobile' => $mobile,
                'nickname' => StringUtil::generateRandomChineseNickname(),
                'password' => password_hash(123456, PASSWORD_DEFAULT),
                'vip' => 0,
            ]);
            if (!$member->save()) {
                throw new ApiException('用户注册失败');
            }
        }
        if (($channelCode = $request->post('channel_code')) && $channelCode > 0) {
            BindChannelCodeJob::dispatch($member->id, $channelCode);
        }
        return Rsp::success([
            'member' => $member,
            'token' => $member->createToken($mobile)->plainTextToken,
        ]);
    }
}
