<?php

//  api软链接至admin
return [
    'keys' => [
        'shop_cover_url', 'shop_background_url', 'shop_name', 'shop_desc', 'business_start_at', 'business_end_at',
        'shop_longitude', 'shop_latitude', 'minimum_price',
    ],

    'url_keys' => [
        'shop_cover_url', 'shop_background_url',
    ],

    'default' => [
        'shop_cover_url'      => '',
        'shop_background_url' => '',
        'shop_name'           => '店铺名',
        'shop_desc'           => '店铺简介',
        'business_start_at'   => '00:00:00',
        'business_end_at'     => '23:59:59',
        'shop_longitude'      => '0.00',
        'shop_latitude'       => '0.00',
        'minimum_price'       => 0,
    ],
];