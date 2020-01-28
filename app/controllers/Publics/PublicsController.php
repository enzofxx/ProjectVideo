<?php
namespace App\Controllers\Publics;

use App\Controllers\Controller;
use App\Courses;

class PublicsController extends Controller
{
    public function index()
    {
        $route = 'home';
        $courses = Courses::select('*')->getAll();
        return view('public/index', [
            'courses' => $courses,
            'route' => $route,
            ]);
    }

    public function about()
    {
        $route = 'about';
        return view('public/aboutUs', [
            'route' => $route,
        ]);
    }

    public function feedback()
    {
        $route = 'feedback';
        return view('public/feedback', [
            'route' => $route,
        ]);
    }
}