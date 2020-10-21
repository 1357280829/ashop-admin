<?php

namespace App\Admin\Controllers;

use App\Models\AdminUser;
use App\Models\Order;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Widgets\Table;
use Illuminate\Database\Eloquent\Collection;

class OrdersController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '订单';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Order());

        $grid->disableCreateButton();
        $grid->disableExport();

        $grid->model()->collection(function (Collection $collection) {
            $collection->each->append('carts_desc');
            return $collection;
        });

        if (request()->user()->id == 1) {
            $grid->filter(function ($filter) {
                $filter->disableIdFilter();
                $filter->equal('admin_user_id', '商家')->select(AdminUser::where('id', '<>', 1)->pluck('name', 'id'));
            });

            $grid->model()->latest();
        } else {
            $grid->disableFilter();

            $grid->model()
                ->latest()
                ->where('is_paid', 1)
                ->where('admin_user_id', request()->user()->id);
        }

        $grid->column('id', 'ID');
        $grid->column('no', '订单编号')->copyable();
        $grid->column('taking_code', '自取号')->label();
        $grid->column('carts_desc', '已购商品')->expand(function (Order $model) {
            return new Table(
                ['商品名', '购买数量', '单品销售价', '单位', '小计'],
                array_map(function ($cart) {
                    return [
                        'product_name' => $cart['product']['name'],
                        'number' => $cart['number'],
                        'sale_price' => $cart['product']['sale_price'],
                        'unit_name' => $cart['product']['unit_name'],
                        'total_price' => $cart['total_price'],
                    ];
                }, $model->carts)
            );
        });
        $grid->column('phone', '联系电话');
        $grid->column('arrived_time', '自提时间');
        $grid->column('total_price', '合计价');
        $grid->column('remark', '备注');
        $grid->column('created_at', '创建时间')->sortable();

        if (request()->user()->id == 1) {
            $grid->column('is_paid', '是否支付')->bool();
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
        $form = new Form(new Order());

        $form->footer(function (Form\Footer $footer) {
            $footer->disableReset();
            $footer->disableSubmit();
        });

        $form->text('no', '订单编号')->readonly();
        $form->text('taking_code', '自取号')->readonly();
        $form->mobile('phone', '联系电话')->readonly();
        $form->text('arrived_time', '自提时间')->readonly();
        $form->currency('total_price', '合计价')->symbol('￥')->default(0.00)->readonly();
        $form->textarea('remark', '备注')->readonly();

        $form->divider();

        $form->table('carts', '已购商品', function (Form\NestedForm $table) {
                $table->text('product.name', '商品名')->readonly();
                $table->text('number', '购买数量')->readonly();
                $table->currency('product.sale_price', '单品销售价')->symbol('￥')->readonly();
                $table->text('product.unit_name', '单位')->readonly();
                $table->currency('total_price', '小计')->symbol('￥')->readonly();
            })
            ->disable()
            ->disableCreate()
            ->disableDelete();

        return $form;
    }
}
