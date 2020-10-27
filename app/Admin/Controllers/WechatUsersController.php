<?php

namespace App\Admin\Controllers;

use App\Models\WechatUser;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;

class WechatUsersController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '微信用户';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new WechatUser());

        $grid->model()->when(request()->user()->id != 1, function ($query) {
            $query->where('admin_user_id', request()->user()->id);
        });

        $grid->disableCreateButton();
        $grid->disableExport();
        $grid->disableFilter();

        $grid->column('id', 'ID');
        $grid->column('nickname', '用户昵称');
//        $grid->column('phone', '手机号码')->default('-');
        $grid->column('avatar_url', '用户头像')->image('', 50, 50);
        $grid->column('gender', '性别')->using([0 => '未知',1 => '男',2 => '女']);
        $grid->column('country', '所在国');
        $grid->column('province', '所在省');
        $grid->column('city', '所在市');
        $grid->column('created_at', '创建时间')->sortable();

        if (request()->user()->id == 1) {
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
        $form = new Form(new WechatUser());

        $form->hidden('admin_user_id')->default(request()->user()->id);

        $form->text('nickname', '用户昵称');
//        $form->mobile('phone', '手机号码');
        $form->text('unionid', 'unionid')->readonly();
        $form->text('openid_mini_program', '小程序openid')->readonly();
        $form->text('openid_official_account', '公众号openid')->readonly();
        $form->image('avatar_url', '用户头像');
        $form->radio('gender', '性别')->options([1 => '男',2 => '女'])->default(1);
        $form->text('country', '所在国')->readonly();
        $form->text('province', '所在省')->readonly();
        $form->text('city', '所在市')->readonly();

        return $form;
    }
}
