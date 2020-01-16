<?php

namespace App\Controllers;

use App\Core\Router;
use App\Courses;
use App\Lectures;

class CourseController extends controller
{
    public function courses()
    {
        $courses = Courses::select('*')->getall();
        return view('course/courses', ['courses' => $courses]);
    }

    public function videos($id)
    {
        $lecture = Lectures::select('lectures.*')->where('lectures.courseId', '=', $id)->getAll();

        if(!empty($lecture)) {
            return view('course/videos', ['lectures' => $lecture]);
        }
        else
            return view("errors/error404");
    }
}
