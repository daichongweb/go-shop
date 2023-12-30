<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Member;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class MemberController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Member(), function (Grid $grid) {
            $grid->disableRowSelector();
            $grid->disableDeleteButton();
            $grid->disableBatchDelete();
            $grid->column('id')->sortable();
            $grid->column('mobile');
            $grid->column('nickname')->textarea();
            $grid->column('vip')->label(Admin::color()->green());
            $grid->column('status')->switch();
            $grid->column('remark')->textarea();
            $grid->column('created_at')->width(200)->sortable();
            $grid->column('updated_at')->width(200);

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->like('mobile');
                $filter->like('nickname');
                $filter->equal('vip')->select(\App\Models\Member::VIP_MAP);
                $filter->equal('status')->select(\App\Models\Member::STATUS_MAP);
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
        return Show::make($id, new Member(), function (Show $show) {
            $show->disableDeleteButton();
            $show->field('id');
            $show->field('mobile');
            $show->field('nickname');
            $show->field('password');
            $show->field('vip');
            $show->field('status')->using(\App\Models\Member::STATUS_MAP);
            $show->field('remark');
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
        return Form::make(new Member(), function (Form $form) {
            $form->disableDeleteButton();
            $form->display('id');
            $form->text('mobile')->required()->rules(function (Form $form) {
                if (!$form->model()->id) {
                    return 'unique:members,mobile';
                }
            }, ['unique' => '手机号重复'])->minLength(11)->maxLength(11);
            $form->text('nickname')->default('')->maxLength(18);
            $form->password('password')->required()->minLength(6)->default(123456)->help('默认密码123456');
            $form->select('vip')->options(\App\Models\Member::VIP_MAP)->required()->default(0);
            $form->switch('status')->options(\App\Models\Member::STATUS_MAP)->default(1);
            $form->text('remark')->default('')->maxLength(100);

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
