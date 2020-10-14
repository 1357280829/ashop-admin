<?php

namespace App\Admin\Controllers;

use App\Models\AdminUser;
use App\Models\Category;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;

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

        $grid->model()->orderByDesc('created_at');

        $grid->disableExport();

        if (request()->user()->id == 1) {
            $grid->filter(function ($filter) {
                $filter->disableIdFilter();
                $filter->equal('admin_user_id', '商家')->select(AdminUser::where('id', '<>', 1)->pluck('name', 'id'));
            });
        } else {
            $grid->model()->where('admin_user_id', request()->user()->id);

            $grid->disableFilter();
        }

        $grid->column('id', 'ID');
        $grid->column('name', '名称');
        $grid->column('sort', '自定义排序值')->sortable();
        $grid->column('created_at', '创建时间');

        if (request()->user()->id == 1) {
            $grid->column('adminuser.username', '商家账号');
            $grid->column('adminuser.name', '商家名');
        }

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

        $form->hidden('admin_user_id')->default(request()->user()->id);

        $form->text('name', '名称')->required();
        $form->number('sort', '自定义排序值')->default(0);

        return $form;
    }
}
