<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\ApplyRequest;
use App\Http\Response\Rsp;
use App\Models\VipApply;
use Illuminate\Http\JsonResponse;

class ApplyController extends Controller
{
    /**
     * @throws ApiException
     */
    public function create(ApplyRequest $request): JsonResponse
    {
        $validated = $request->validated();
        
        $apply = new VipApply([
            'name' => $validated['name'],
            'mobile' => $validated['mobile'],
            'id_card' => $validated['id_card'],
            'remark' => $validated['remark'],
            'status' => 0
        ]);
        if (!$apply->save()) {
            throw new ApiException('申请失败');
        }
        return Rsp::success();
    }
}
