<?php

//  api软链接至admin
return [
    'keys' => [
        'shop_cover_url', 'shop_background_url', 'shop_name', 'shop_desc', 'business_hours', 'minimum_price',
    ],

    'url_keys' => [
        'shop_cover_url', 'shop_background_url',
    ],

    'default' => [
        'shop_cover_url'      => '',
        'shop_background_url' => '',
        'shop_name'           => '店铺名',
        'shop_desc'           => '店铺简介',
        'business_hours'      => '营业时间',
        'minimum_price'       => 0,
    ],
];