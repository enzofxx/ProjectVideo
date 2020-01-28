<?php
namespace App\Controllers\Publics;

use App\Controllers\Controller;
use App\Courses;

class PublicsController extends Controller
{
    public function index()
    {
        $courses = Courses::select('*')->getAll();
        return view('public/index', ['courses' => $courses]);
    }
}