<?php
namespace App\Controllers\Publics;

use App\Controllers\Controller;
use App\Core\Service;
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
            'loginUrl' => Service::get('googleAPI')->getLoginUrl()
            ]);
    }

    public function about()
    {
        $route = 'about';
        return view('public/aboutUs', [
            'route' => $route,
            'loginUrl' => Service::get('googleAPI')->getLoginUrl()
        ]);
    }

    public function feedback()
    {
        $route = 'feedback';
        return view('public/feedback', [
            'route' => $route,
            'loginUrl' => Service::get('googleAPI')->getLoginUrl()
        ]);
    }
}
