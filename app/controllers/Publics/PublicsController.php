<?php
namespace App\Controllers\Publics;

use App\Controllers\Controller;
use App\Core\Service;
use App\Courses;
use App\Users;
use http\Client\Curl\User;

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

            $password = $user->password ?? '';

            if($enteredPassword == $password){
                $user = Users::select('*')->where('email', '=', "'" . $enteredEmail . "'")->get();
                Service::get('session')->set('user', $user);
                if($user->role == 'admin'){
                    return redirect('admin')->render('admin.index');
                } else {
                    return redirect('course')->render('course.index');
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
        $userRole = Service::get('session')->get('user')->role ?? null;
        $route = 'home';
        $loginurl = Service::get('googleAPI')->getLoginUrl() ?? null;
        $courses = Courses::select('*')->getAll();
        $user = Service::get('session')->get('user');

        return view('public/index', [
            'userRole' => $userRole,
            'courses' => $courses,
            'route' => $route,
            'loginUrl' => $loginurl,
            'user' => $user,
            ]);
    }

    public function about()
    {
        $userRole = Service::get('session')->get('user')->role ?? null;
        $route = 'about';
        return view('public/aboutUs', [
            'userRole' => $userRole,
            'route' => $route,
            'loginUrl' => Service::get('googleAPI')->getLoginUrl()
        ]);
    }

    public function feedback()
    {
        $userRole = Service::get('session')->get('user')->role ?? null;
        $route = 'feedback';
        return view('public/feedback', [
            'userRole' => $userRole,
            'route' => $route,
            'loginUrl' => Service::get('googleAPI')->getLoginUrl()
        ]);
    }

    public function logout()
    {
        Service::get('session')->invalidate();
        return redirect()->route('home');
    }
}
