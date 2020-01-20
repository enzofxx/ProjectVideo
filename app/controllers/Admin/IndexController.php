<?php
namespace App\Controllers\Admin;

use App\Core\Config;
use App\Courses;

class IndexController
{
    public function index()
    {
        $courses = Courses::select('*')->getAll();
        return view('admin/index', ["title" => Config::get('config', 'name'),
                                            "courses" => $courses]);
    }

}