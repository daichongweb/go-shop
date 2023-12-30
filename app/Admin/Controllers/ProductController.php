<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Product;
use App\Models\Member;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class ProductController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Product(), function (Grid $grid) {
            $grid->disableDeleteButton();
            $grid->disableBatchDelete();
            $grid->disableRowSelector();
            $grid->column('id')->sortable();
            $grid->column('name')->textarea();
            $grid->column('price')->display(function ($va) {
                return '<font color="red">¥' . ($va / 100) . '</font>';
            });
            $grid->column('description');
            $grid->column('status')->switch();
            $grid->column('created_at')->width(200)->sortable();
            $grid->column('updated_at')->width(200);
            $grid->model()->orderBy('status', 'desc')->orderBy('created_at', 'desc');
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->like('name');
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
        return Show::make($id, new Product(), function (Show $show) {
            $show->disableDeleteButton();
            $show->field('id');
            $show->field('name');
            $show->field('price');
            $show->field('description');
            $show->field('status')->using(Member::STATUS_MAP);
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
        return Form::make(new Product(), function (Form $form) {
            $form->disableDeleteButton();
            $form->display('id');
            $form->text('name')->maxLength(40)->minLength(2);
            $form->number('price')->min(1)->default(1);
            $form->text('description')->maxLength(128)->default('');
            $form->switch('status')->options(Member::STATUS_MAP)->default(1);

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
