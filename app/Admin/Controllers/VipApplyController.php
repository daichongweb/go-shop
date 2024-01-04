<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Grid\BatchPassAction;
use App\Admin\Actions\Grid\BatchRejectAction;
use App\Admin\Repositories\VipApply;
use App\Models\Order;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class VipApplyController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new VipApply(), function (Grid $grid) {
            $grid->disableBatchDelete();
            $grid->disableDeleteButton();
            $grid->disableCreateButton();
            $grid->disableEditButton();
            $grid->column('id')->sortable();
            $grid->column('name');
            $grid->column('mobile');
            $grid->column('id_card');
            $grid->column('type')->using(\App\Models\VipApply::TYPE_MAP);
            $grid->column('status')->using(\App\Models\VipApply::STATUS_MAP)->label(\App\Models\VipApply::STATUS_COLOR);
            $grid->column('remark', '备注')->display(function ($va) {
                return $va ?: '无';
            })->textarea();
            $grid->column('reject_message', '驳回原因')->display(function ($va) {
                return $va ?: '无';
            })->textarea();
            $grid->column('created_at')->width(200);
            $grid->column('updated_at')->width(200)->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');

            });

            $grid->batchActions(function ($batch) {
                $batch->add(new BatchPassAction());
                $batch->add(new BatchRejectAction());
            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new VipApply(), function (Show $show) {
            $show->disableDeleteButton();
            $show->disableEditButton();
            $show->field('id');
            $show->field('name');
            $show->field('mobile');
            $show->field('id_card');
            $show->field('type');
            $show->field('status');
            $show->field('remark', '备注')->as(function ($va) {
                return $va ?: '无';
            });
            $show->field('reject_message', '驳回原因')->as(function ($va) {
                return $va ?: '无';
            });
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new VipApply(), function (Form $form) {
            $form->display('id');
            $form->text('name');
            $form->text('mobile');
            $form->text('id_card');
            $form->text('type');
            $form->text('status');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
