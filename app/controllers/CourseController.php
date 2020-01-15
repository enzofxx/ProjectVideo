<?php

namespace App\Controllers;

use App\Core\Router;

class CourseController extends controller
{
    public function courses()
    {
        return view('course/courses');
    }

    public function videos()
    {
        return view('course/videos');
    }
}
