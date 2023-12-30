<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Response\Rsp;
use App\Models\Member;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $model = Order::query()->with(['referenceMember', 'member', 'payMember', 'product'])->where('member_id', $request->user()->id);
        if ($payMemberId = $request->get('payMemberId')) {
            $payMemberId = $this->getIdByMobile($payMemberId);
            $model->whereHas('payMember', function (Builder $query) use ($payMemberId) {
                $query->where('pay_member_id', $payMemberId);
            });
        }
        if ($referenceMemberId = $request->get('referenceMemberId')) {
            $referenceMemberId = $this->getIdByMobile($referenceMemberId);
            $model->whereHas('referenceMember', function (Builder $query) use ($referenceMemberId) {
                $query->where('reference_member_id', $referenceMemberId);
            });
        }

        if ($productId = $request->get('productId')) {
            $model->whereHas('product', function (Builder $query) use ($productId) {
                $query->where('product_id', $productId);
            });
        }
        $list = $model->paginate();
        return Rsp::page($list);
    }

    /**
     * @throws ApiException
     */
    public function create(Request $request): JsonResponse
    {
        $payMobile = $request->post('payMobile');
        if (!$payMobile) {
            throw new ApiException('请填写购买人手机号');
        }
        $payMemberId = $this->getIdByMobile($payMobile);
        if (!$payMemberId) {
            throw new ApiException('购买人未注册');
        }
        $referenceMobile = $request->post('referenceMobile');
        $referenceMemberId = $this->getIdByMobile($referenceMobile);
        if (!$referenceMemberId) {
            throw new ApiException('推荐人未注册');
        }
        $productId = $request->post('productId');
        if (!$productId) {
            throw new ApiException('商品不存在');
        }
        if (!Product::query()->where('id', $productId)->exists()) {
            throw new ApiException('商品不存在');
        }
        $price = $request->post('price');
        if (!is_numeric($price)) {
            throw new ApiException('金额必须是整数');
        }
        $num = $request->post('num');
        if (!is_numeric($num)) {
            throw new ApiException('数量必须是整数');
        }

        $model = new Order([
            'member_id' => $request->user()->id,
            'pay_member_id' => $payMemberId,
            'reference_member_id' => $referenceMemberId,
            'product_id' => $productId,
            'pay_price' => $price,
            'num' => $num,
            'status' => 0
        ]);
        if (!$model->save()) {
            throw new ApiException('订单创建失败');
        }
        return Rsp::success();
    }

    private function getIdByMobile($mobile)
    {
        return Member::query()->where('mobile', $mobile)->value('id');
    }
}
