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

        $grid->disableExport();
        $grid->disablePagination();
        $grid->disableFilter();
        $grid->disableRowSelector();
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableView();
            $actions->disableDelete();
        });

        $grid->column('id', 'ID');
        $grid->column('key', '商家KEY')->width(470)->copyable();
        $grid->column('business_license_code', '组织机构代码');
        $grid->column('business_license_name', '营业执照名称');
        $grid->column('is_enable_bill_service', '发票服务开关')->switch();
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
        $key = md5($keyIndex) . md5($keyIndex . '-' . request()->admin_user_id . '-' . microtime());
        $form->hidden('key')->default($key);

        $form->select('admin_user_id', '商家后台账号名')
            ->options(AdminUser::where('id', '<>', 1)->pluck('name', 'id'))
            ->creationRules(['required', 'unique:stores,admin_user_id'])
            ->updateRules(['required', 'unique:stores,admin_user_id,{{id}}']);

        $form->text('business_license_code', '组织机构代码');
        $form->text('business_license_name', '营业执照名称');
        $form->switch('is_enable_bill_service', '发票服务');

        return $form;
    }
}
