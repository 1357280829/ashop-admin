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

        $grid->disableExport();
        $grid->disablePagination();
        $grid->disableFilter();
        $grid->disableRowSelector();

        $grid->column('id', 'ID');
        $grid->column('key', '商家KEY')->width(500)->copyable();
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

        $form->hidden('key');

        $options = AdminUser::query()
            ->when($form->isEditing(), function ($query) {
                return $query->where(function ($subQuery) {
                    return $subQuery->doesntHave('stores')
                        ->orWhereHas('stores', function ($deepQuery) {
                            return $deepQuery->whereKey(request()->route()->parameters()['store']);
                        });
                });
            }, function ($query) {
                return $query->doesntHave('stores');
            })
            ->where('id', '<>', 1)
            ->pluck('name', 'id');
        $form->select('admin_user_id', '商家后台账号名')->options($options);
        $form->text('business_license_code', '组织机构代码');
        $form->text('business_license_name', '营业执照名称');
        $form->switch('is_enable_bill_service', '发票服务');

        $form->text('mini_program_appid', '小程序AppID');
        $form->text('mini_program_app_secret', '小程序AppSecret');
        $form->text('payment_mch_id', '商户号ID');
        $form->text('payment_key', '商户号API密钥');

        $form->saving(function (Form $form) {
            $keyIndex = 'ashop-admin_user';
            $form->key = $form->key ?: md5($keyIndex) . md5($keyIndex . '-' . request()->admin_user_id . '-' . config_path('app.key'));
        });

        return $form;
    }
}
