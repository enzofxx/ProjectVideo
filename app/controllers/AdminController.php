<?php

namespace App\Controllers;

use App\Core\Router;

class AdminController extends controller
{
    public function courses()
    {
        return view('admin/admin');
    }

    public function videos()
    {
        return view('admin/videos');
    }
}
