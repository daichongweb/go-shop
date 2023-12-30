<?php

namespace App\Http\Controllers;

use App\Http\Response\Rsp;
use App\Models\Member;
use App\Models\Order;
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

    private function getIdByMobile($mobile)
    {
        return Member::query()->where('mobile', $mobile)->value('id');
    }
}
