<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Core\Config;

class IndexController extends Controller
{
    public function index()
    {
        return view('admin/index', ["title" => Config::get('config', 'name')]);
    }
}
