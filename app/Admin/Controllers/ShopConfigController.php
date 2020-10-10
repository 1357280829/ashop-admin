<?php

namespace App\Admin\Controllers;

use App\Admin\Forms\ShopConfig;
use App\Http\Controllers\Controller;
use Encore\Admin\Layout\Content;

class ShopConfigController extends Controller
{
    public function index(Content $content)
    {
        return $content->body(new ShopConfig());
    }
}