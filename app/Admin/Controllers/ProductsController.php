<?php

namespace App\Admin\Controllers;

use App\Models\Category;
use App\Models\Product;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ProductsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '商品';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Product());

        $grid->disableExport();
        $grid->disableFilter();

        $grid->column('id', 'ID');
        $grid->column('name', '商品名');
        $grid->column('cover_url', '封面图')->image('', 50, 50);
        $grid->column('categories', '所属分类')->pluck('name')->label();
        $grid->column('sale_price', '销售价');
        $grid->column('packing_price', '包装费');
        $grid->column('stock', '库存');
        $grid->column('is_on', '上架开关')->switch();
        $grid->column('sort', '自定义排序值');
        $grid->column('unit_name', '单位');
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
        $form = new Form(new Product());

        $form->multipleSelect('categories', '所属分类')->options(Category::pluck('name', 'id'));

        $form->divider();

        $form->text('name', '商品名')->required();
        $form->image('cover_url', '封面图')->required();
        $form->currency('sale_price', '销售价')->symbol('￥')->default(0.00)->required();
        $form->currency('packing_price', '包装费')->symbol('￥')->default(0.00)->required();
        $form->text('unit_name', '单位')->default('1人份')->required();
        $form->number('stock', '库存')->default(1)->rules('required|integer|min:1');
        $form->number('sort', '自定义排序值')->default(0);
        $form->switch('is_on', '上架开关');

        return $form;
    }
}
