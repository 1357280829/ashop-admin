<?php

namespace App\Admin\Controllers;

use App\Models\Category;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CategoriesController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '分类';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Category());

        $grid->disableFilter();
        $grid->disableExport();

        $grid->column('id', 'ID');
        $grid->column('name', '名称');
        $grid->column('sort', '自定义排序值');
        $grid->column('created_at', '创建时间');

        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Category());

        $form->text('name', '名称')->required();
        $form->number('sort', '自定义排序值')->default(0);

        return $form;
    }
}
