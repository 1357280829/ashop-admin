<?php

namespace App\Admin\Extensions;

use Encore\Admin\Grid\Exporters\ExcelExporter;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExporter extends ExcelExporter implements WithMapping
{
    protected $fileName = '商品列表.xlsx';

    protected $columns = [
        'id' => 'ID',
        'name' => '商品名',
        'categories' => '所属分类',
        'sale_price' => '销售价',
        'unit_name' => '单位',
        'packing_price' => '包装费',
        'stock' => '库存量',
        'is_on' => '是否上架',
    ];

    public function map($product) : array
    {
        return [
            $product->id,
            $product->name,
            data_get($product, 'categories')->pluck('name')->implode(','),
            $product->sale_price,
            $product->unit_name,
            $product->packing_price,
            $product->stock,
            $product->is_on ? '是' : '否',
        ];
    }
}