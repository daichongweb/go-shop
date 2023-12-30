<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Response\Rsp;
use App\Models\Member;
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
}
