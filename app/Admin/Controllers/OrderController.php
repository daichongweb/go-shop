<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Order;
use App\Admin\Repositories\Product;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class OrderController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(Order::with(['referenceMember', 'member', 'payMember', 'product']), function (Grid $grid) {
            $grid->disableRowSelector();
            $grid->disableDeleteButton();
            $grid->disableCreateButton();
            $grid->disableEditButton();
            $grid->column('id')->sortable();
            $grid->column('member.mobile', '所属人');
            $grid->column('payMember.mobile', '购买人');
            $grid->column('referenceMember.mobile', '推荐人');
            $grid->column('product.name', '商品');
            $grid->column('pay_price')->display(function ($va) {
                return '<font color="red">¥' . ($va / 100) . '</font>';
            });
            $grid->column('num');
            $grid->column('status')->using(\App\Models\Order::STATUS_MAP)->label(\App\Models\Order::STATUS_COLOR);
            $grid->column('created_at')->width(200)->sortable();
            $grid->column('updated_at')->width(200);

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->where('payMobile', function ($query) {
                    $query->whereHas('payMember', function ($query) {
                        $query->where('mobile', 'like', "%{$this->input}%");
                    });
                }, '购买人');

                $filter->where('referenceMobile', function ($query) {
                    $query->whereHas('referenceMember', function ($query) {
                        $query->where('mobile', 'like', "%{$this->input}%");
                    });
                }, '推荐人');

                $filter->equal('productId', '商品')->select(array_column(\App\Models\Product::query()->select(['id', 'name'])->get()->toArray(), 'name', 'id'));

                $filter->equal('status')->select(\App\Models\Order::STATUS_MAP);
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
        return Show::make($id, Order::with(['referenceMember', 'member', 'payMember', 'product']), function (Show $show) {
            $show->disableDeleteButton();
            $show->disableEditButton();
            $show->field('id');
            $show->field('member.mobile', '所属人');
            $show->field('pay_member.mobile', '购买人');
            $show->field('reference_member.mobile', '推荐人');
            $show->field('product.name', '商品');
            $show->field('pay_price')->as(function ($val) {
                return ($val / 100);
            });
            $show->field('num');
            $show->field('status')->using(\App\Models\Order::STATUS_MAP);
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
        return Form::make(new Order(), function (Form $form) {
            $form->display('id');
            $form->text('member_id');
            $form->text('pay_member_id');
            $form->text('reference_member_id');
            $form->text('product_id');
            $form->text('pay_price');
            $form->text('num');
            $form->text('status');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
