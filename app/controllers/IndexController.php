<?php

namespace App\Controllers;

use App\Core\Config;
use App\Topic;

class indexController extends Controller
{

    public function __construct()
    {
        // Home Controller
    }

    public function index()
    {
        return view('index', ["title" => Config::get('config', 'name')]);
    }
}
