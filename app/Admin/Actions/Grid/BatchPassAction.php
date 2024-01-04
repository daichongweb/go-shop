<?php

namespace App\Admin\Actions\Grid;

use App\Models\Member;
use Dcat\Admin\Actions\Response;
use Dcat\Admin\Grid\BatchAction;
use Dcat\Admin\Traits\HasPermissions;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class BatchPassAction extends BatchAction
{
    /**
     * @return string
     */
    protected $title = '批量通过';

    /**
     * Handle the action request.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function handle(Request $request)
    {
        $keys = $this->getKey();
        if (!$keys) {
            return $this->response()->error("请选择处理记录");
        }
        $types = [];
        $applyList = \App\Models\VipApply::query()->whereIn('id', $keys)->get();
        $applyList->each(function ($apply) use (&$types) {
            if ($apply->update(['status' => 1])) {
                $types[] = [
                    'mobile' => $apply->mobile,
                    'type' => $apply->type
                ];
            }
        });
        $types = array_column($types, 'type', 'mobile');
        $mobiles = array_keys($types);
        $members = Member::query()->whereIn('mobile', $mobiles)->get();
        $members->each(function ($member) use ($types) {
            $member->update(['vip' => $types[$member->mobile]]);
        });
        return $this->response()
            ->success('处理成功')->refresh();
    }

    /**
     * @return string|array|void
     */
    public function confirm()
    {
        return ['确认全部操作通过吗?', '操作后无法恢复'];
    }

    /**
     * @param Model|Authenticatable|HasPermissions|null $user
     *
     * @return bool
     */
    protected function authorize($user): bool
    {
        return true;
    }

    /**
     * @return array
     */
    protected function parameters()
    {
        return [];
    }
}
