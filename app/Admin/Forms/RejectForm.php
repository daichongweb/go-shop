<?php

namespace App\Admin\Forms;

use App\Models\VipApply;
use Dcat\Admin\Contracts\LazyRenderable;
use Dcat\Admin\Traits\LazyWidget;
use Dcat\Admin\Widgets\Form;

class RejectForm extends Form implements LazyRenderable
{
    use LazyWidget;

    /**
     * Handle the form request.
     *
     * @param array $input
     *
     * @return mixed
     */
    public function handle(array $input)
    {
        $id = explode(',', $input['id'] ?? null);
        if (!$id) {
            return $this->response()->error("请选择处理记录");
        }
        $apply = VipApply::query()->whereIn('id', $id)->get();
        if ($apply->isEmpty()) {
            return $this->response()->error('申请记录不存在' . json_encode($id));
        }
        $msg = $input['reject_message'];
        $apply->each(function ($user) use ($msg) {
            $user->update(['status' => -1, 'reject_message' => $msg]);
        });
        return $this
            ->response()
            ->success('操作成功')
            ->refresh();
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $this->textarea('reject_message', '驳回原因')->required();
        $this->hidden('id')->attribute('id', 'reject-apply-id');
    }

    /**
     * The data of the form.
     *
     * @return array
     */
    public function default()
    {
        return [
            'reject_message' => '信息不完整',
        ];
    }
}
