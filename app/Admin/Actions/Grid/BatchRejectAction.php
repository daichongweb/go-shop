<?php

namespace App\Admin\Actions\Grid;

use App\Admin\Forms\BatchRejectApplyForm;
use App\Admin\Forms\RejectForm;
use Dcat\Admin\Actions\Response;
use Dcat\Admin\Grid\BatchAction;
use Dcat\Admin\Traits\HasPermissions;
use Dcat\Admin\Widgets\Modal;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class BatchRejectAction extends BatchAction
{
    /**
     * @return string
     */
    protected $title = '批量驳回';

    /**
     * Handle the action request.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function render(): string|Modal
    {
        $form = RejectForm::make();

        return Modal::make()
            ->lg()
            ->title($this->title)
            ->body($form)
            ->onLoad($this->getModalScript())
            ->button($this->title);
    }

    /**
     * Handle the action request.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function handle(Request $request)
    {
        return $this->response()
            ->success('Processed successfully.')
            ->redirect('/');
    }

    protected function getModalScript()
    {
        // 弹窗显示后往隐藏的id表单中写入批量选中的行ID
        return <<<JS
// 获取选中的ID数组
var key = {$this->getSelectedKeysScript()}

$('#reject-apply-id').val(key);
JS;
    }
}
