<?php

namespace App\Admin\Forms;

use Encore\Admin\Widgets\Form;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

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
        $keys = config('shopconfig.keys');
        $urlKeys = config('shopconfig.url_keys');

        Log::info($request->all());

        foreach ($request->all() as $key => $value) {
            if (in_array($key, $keys)) {
                if (in_array($key, $urlKeys) && $value instanceof UploadedFile) {
                    $value = $value->store('shopconfig', 'admin');
                }
                \App\Models\ShopConfig::updateOrCreate(
                    ['key' => $key, 'admin_user_id' => $request->user()->id],
                    ['value' => $value]
                );
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
        $this->hidden('admin_user_id', request()->user()->id);

        $this->image('shop_cover_url', '店铺封面图');
        $this->image('shop_background_url', '店铺背景图');
        $this->text('shop_name', '店铺名');
        $this->text('shop_desc', '店铺简介');
        $this->time('business_start_at', '营业开始时间')->format('HH:mm');
        $this->time('business_end_at', '营业结束时间')->format('HH:mm');
        $this->text('shop_address_detail', '店铺地址详细信息');
        $this->latlong('shop_latitude', 'shop_longitude', '店铺所在地');
        $this->currency('minimum_price', '最低消费')->symbol('￥');
    }

    /**
     * The data of the form.
     *
     * @return array $data
     */
    public function data()
    {
        $shopConfigs = \App\Models\ShopConfig::query()
            ->where('admin_user_id', request()->user()->id)
            ->whereIn('key', config('shopconfig.keys'))
            ->pluck('value', 'key')
            ->toArray();

        $defaultShopConfigs = config('shopconfig.default');

        return [
            'shop_cover_url'      => $shopConfigs['shop_cover_url']      ?? $defaultShopConfigs['shop_cover_url'],
            'shop_background_url' => $shopConfigs['shop_background_url'] ?? $defaultShopConfigs['shop_background_url'],
            'shop_name'           => $shopConfigs['shop_name']           ?? $defaultShopConfigs['shop_name'],
            'shop_desc'           => $shopConfigs['shop_desc']           ?? $defaultShopConfigs['shop_desc'],
            'business_start_at'   => $shopConfigs['business_start_at']   ?? $defaultShopConfigs['business_start_at'],
            'business_end_at'     => $shopConfigs['business_end_at']     ?? $defaultShopConfigs['business_end_at'],
            'shop_longitude'      => $shopConfigs['shop_longitude']      ?? $defaultShopConfigs['shop_longitude'],
            'shop_latitude'       => $shopConfigs['shop_latitude']       ?? $defaultShopConfigs['shop_latitude'],
            'shop_address_detail' => $shopConfigs['shop_address_detail'] ?? $defaultShopConfigs['shop_address_detail'],
            'minimum_price'       => $shopConfigs['minimum_price']       ?? $defaultShopConfigs['minimum_price'],
        ];
    }
}
