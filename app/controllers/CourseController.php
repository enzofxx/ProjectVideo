<?php

namespace App\Controllers;

use App\Core\Router;
use App\Courses;
use App\Lectures;

class CourseController extends controller
{
    public function index()
    {
        $courses = Courses::select('*')->getAll();
        return view('course/index', ['courses' => $courses]);
    }

    public function show($id)
    {
        $lecture = Lectures::select('lectures.*')->where('lectures.courseId', '=', $id)->getAll();

        if(!empty($lecture)) {
            return view('course/show', ['lectures' => $lecture]);
        }
        else
            return view("errors/error404");
    }
}
