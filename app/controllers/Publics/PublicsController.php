<?php

namespace App\Controllers\Publics;

use App\Controllers\Controller;
use App\Core\Service;
use App\Courses;
use App\Users;

class PublicsController extends Controller
{

    public function login()
    {
        $postData = Service::get('request')->request;
        $enteredEmail = $postData->get('email');
        $enteredPassword = $postData->get('password');

        if(!empty($enteredEmail) && !empty($enteredPassword)){
            $user = Users::select('password, role')
                ->where("email", '=', "'" . $enteredEmail . "'")
                ->get();

            if($enteredPassword == $user->password){
                Service::get('session')->set('role', $user->role);

                if($user->role == 'admin'){
                    return redirect()->route('admin.index');
                }
            }
        }

        $route = 'home';
        $error = 'Blogai Įvestas Slaptažodis Arba El Pašto Adresas';
        $courses = Courses::select('*')->getAll();
        return view('public/index', [
            'error' => $error,
            'courses' => $courses,
            'route' => $route,
        ]);
    }

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