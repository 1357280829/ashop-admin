<?php

namespace App\Admin\Controllers;

use App\Models\AdminUser;
use App\Models\Store;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;

class StoresController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '商家';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Store());

        $grid->model()->orderByDesc('created_at');

        $grid->disableActions();
        $grid->disableExport();
        $grid->disablePagination();
        $grid->disableFilter();
        $grid->disableRowSelector();

        $grid->column('id', 'ID');
        $grid->column('key', '商家KEY')->width(500)->copyable();
        $grid->column('adminuser.id', '商家后台账号ID');
        $grid->column('adminuser.username', '商家后台账号');
        $grid->column('adminuser.name', '商家后台账号名');
        $grid->column('created_at', '创建时间')->sortable();

        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Store());

        $keyIndex = 'ashop-admin_user';
        $form->hidden('key')->default(md5($keyIndex) . md5($keyIndex . '-' . request()->admin_user_id . '-' . microtime()));
        $form->select('admin_user_id', '商家后台账号名')
            ->options(AdminUser::doesntHave('stores')->where('id', '<>', 1)->pluck('name', 'id'))
            ->required();

        return $form;
    }
}
