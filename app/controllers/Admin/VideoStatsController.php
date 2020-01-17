<?php


namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Core\Config;

class VideoStatsController
{
    public function index()
    {
        return view('admin/videostats', ["title" => Config::get('config', 'name')]);
    }
}