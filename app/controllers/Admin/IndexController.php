<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Core\Config;
use App\Topic;

class IndexController extends Controller
{
    public function index()
    {
        echo ('<h1>This is admin panel</h1>');
        return view('index', ["title" => Config::get('config', 'name')]);
    }
}