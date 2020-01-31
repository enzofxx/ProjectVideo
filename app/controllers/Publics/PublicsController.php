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
                    return redirect()->route('admin.index');
                } else {
                    return redirect()->route('course.index');
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

    public function logout()
    {
        Service::get('session')->invalidate();
        return redirect()->route('home');
    }
}
