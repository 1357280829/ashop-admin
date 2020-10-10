<?php

namespace App\Admin\Forms;

use Encore\Admin\Widgets\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ShopConfig extends Form
{
    /**
     * The form title.
     *
     * @var string
     */
    public $title = '商城设置';

    protected $fillable = [
        'shop_name', 'shop_desc', 'business_hours', 'packing_price', 'delivery_price',
    ];

    /**
     * Handle the form request.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request)
    {
        foreach ($request->input() as $key => $value) {
            if (in_array($key, $this->fillable)) {
                Cache::put($key, $value);
            }
        }

        admin_toastr('设置成功');

        return back();
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $this->text('shop_name', '店铺名');
        $this->text('shop_desc', '店铺简介');
        $this->text('business_hours', '营业时间');

        $this->divider();

        $this->currency('packing_price', '包装费')->symbol('￥');
        $this->currency('delivery_price', '配送费')->symbol('￥');
    }

    /**
     * The data of the form.
     *
     * @return array $data
     */
    public function data()
    {
        return [
            'shop_name'      => Cache::get('shop_name')      ?: '店铺名',
            'shop_desc'      => Cache::get('shop_desc')      ?: '店铺简介',
            'business_hours' => Cache::get('business_hours') ?: '营业时间',

            'packing_price'  => Cache::get('packing_price')  ?: 0.00,
            'delivery_price' => Cache::get('delivery_price') ?: 0.00,
        ];
    }
}
