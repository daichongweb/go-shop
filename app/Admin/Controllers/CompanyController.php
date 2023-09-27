<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Company;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Config;

class CompanyController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $host = env('APP_URL_STORAGE');
        return Grid::make(new Company(), function (Grid $grid) use ($host) {
            $grid->column('id')->sortable();
            $grid->column('name');
            $grid->column('tax_number');
            $grid->column('business_img')->image($host, 50, 50)->width(100);
            $grid->column('id_card_main_img')->image($host, 50, 50)->width(100);
            $grid->column('id_card_back_img')->image($host, 50, 50)->width(100);
            $grid->column('status')->using(Company::statusMap())->dot(Config::get('admin.statusColor'));
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');

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
        return Show::make($id, new Company(), function (Show $show) {
            $show->field('id');
            $show->field('id');
            $show->field('name');
            $show->field('tax_number');
            $show->field('business_img');
            $show->field('id_card_main_img');
            $show->field('id_card_back_img');
            $show->field('status');
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
        return Form::make(new Company(), function (Form $form) {
            $form->display('id');
            $form->text('name')->required();
            $form->text('tax_number')->required();
            $form->image('business_img')->required();
            $form->image('id_card_main_img')->required();
            $form->image('id_card_back_img')->required();

            $form->display('status');
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
