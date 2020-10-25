<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\ProductsExporter;
use App\Models\AdminUser;
use App\Models\Category;
use App\Models\Product;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;

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

        $grid->model()->orderByDesc('created_at');

        $grid->exporter(new ProductsExporter());

        if (request()->user()->id == 1) {
            $grid->filter(function ($filter) {
                $filter->disableIdFilter();
                $filter->equal('admin_user_id', '商家')->select(AdminUser::where('id', '<>', 1)->pluck('name', 'id'));
            });
        } else {
            $grid->model()->where('admin_user_id', request()->user()->id);

            $grid->disableFilter();

            $categoryOptions = Category::where('admin_user_id', request()->user()->id)->pluck('name', 'id');
            $grid->selector(function (Grid\Tools\Selector $selector) use ($categoryOptions) {
                $selector->select('categories', '所属分类', $categoryOptions, function ($query, $categoryIds) {
                    $query->whereHas('categories', function ($subQuery) use ($categoryIds) {
                        return $subQuery->whereIn('categories.id', $categoryIds);
                    });
                });
            });
        }

        $grid->column('id', 'ID');
        $grid->column('name', '商品名');
        $grid->column('cover_url', '封面图')->image('', 50, 50);
        $grid->column('categories', '所属分类')->pluck('name')->label();
        $grid->column('sale_price', '销售价')->sortable();
        $grid->column('packing_price', '包装费')->sortable();
        $grid->column('stock', '库存')->sortable();
        $grid->column('is_on', '上架开关')->switch();
        $grid->column('sort', '自定义排序值')->sortable();
        $grid->column('unit_name', '单位');
        $grid->column('created_at', '创建时间')->sortable();

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
        $form = new Form(new Product());

        $form->hidden('admin_user_id')->default(request()->user()->id);

        $categoryOptions = Category::query()
            ->when(request()->user()->id != 1, function ($query) {
                $query->where('admin_user_id', request()->user()->id);
            })
            ->pluck('name', 'id');
        $form->multipleSelect('categories', '所属分类')->options($categoryOptions);

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
