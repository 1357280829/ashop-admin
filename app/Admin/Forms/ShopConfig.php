<?php

namespace App\Admin\Forms;

use Encore\Admin\Widgets\Form;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class ShopConfig extends Form
{
    /**
     * The form title.
     *
     * @var string
     */
    public $title = '商城设置';

    /**
     * Handle the form request.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request)
    {
        foreach ($request->all() as $key => $value) {
            if (in_array($key, config('shopconfig.keys'))) {
                if ($value instanceof UploadedFile) {
                    $value = $value->store('shopconfig', 'admin');
                }
                \App\Models\ShopConfig::updateOrCreate(['key' => $key], ['value' => $value]);
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
        $this->image('shop_cover_url', '店铺封面图');
        $this->text('shop_name', '店铺名');
        $this->text('shop_desc', '店铺简介');
        $this->text('business_hours', '营业时间');
    }

    /**
     * The data of the form.
     *
     * @return array $data
     */
    public function data()
    {
        $shopConfigs = \App\Models\ShopConfig::query()
            ->whereIn('key', config('shopconfig.keys'))
            ->pluck('value', 'key')
            ->toArray();

        $defaultShopConfigs = config('shopconfig.default');

        return [
            'shop_cover_url' => $shopConfigs['shop_cover_url'] ?? $defaultShopConfigs['shop_cover_url'],
            'shop_name'      => $shopConfigs['shop_name']      ?? $defaultShopConfigs['shop_name'],
            'shop_desc'      => $shopConfigs['shop_desc']      ?? $defaultShopConfigs['shop_desc'],
            'business_hours' => $shopConfigs['business_hours'] ?? $defaultShopConfigs['business_hours'],
        ];
    }
}
