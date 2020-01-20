<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Core\Config;
use App\Users;
use App\Courses;
use App\Lectures;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    public function addCourse()
    {
        $lectures = Lectures::select('lectures.*')->limit(5)->getAll();
        return view('admin/addCourse', ['lectures' => $lectures]);
    }

    public function storeCourse(Request $request)
    {
        $data = $request->request->all();
        $target_dir = rtrim(($_SERVER['DOCUMENT_ROOT'] . config::get('config', 'root')), '/public/') . '/resources/uploads/';
        $target_file = $target_dir . basename($_FILES["picture"]["name"]);
        move_uploaded_file($_FILES['picture']['tmp_name'], $target_file);

        if (!isset($data['name']) || !isset($data['about']) || !isset($data['price']) || !isset($_FILES)) {
            return view('errors/error404');
        } else {
            $query = [
                "name" => $data['name'],
                "about" => $data['about'],
                "price" => $data['price'],
                "picture" => '../resources/uploads/' . $_FILES["picture"]["name"]
            ];

            if (strlen($query['name']) <= 0 || strlen($query['about']) <= 0 || strlen($query['price']) <= 0 || strlen($_FILES["picture"]["name"]) <= 0) {
                return view('errors/error404');
            }
            Courses::insert($query);
            $lecturesQuery = ["courseId" => get_object_vars(Courses::select('*')->max('id')->get())['MAX(id)'], "videoUrl" => 'https://www.youtube.com/embed/wjipJEho3EU'];
            Lectures::insert($lecturesQuery);
            return view('admin/index', ["title" => Config::get('config', 'name')]);
        }
    }

    public function showUser()
    {
        $users = Users::select('*')->groupBy('lastLogin, visitCount')->limit(10)->getAll();
        return view('admin/users', ['users' => $users]);
    }

    public function userPagination()
    {
        $perPage = 10;
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

        if ($page >= 0) {
            $users = Users::select('users.*')->groupBy('lastLogin, visitCount')->pagination($perPage, $page);
        }
        $users = $users->getAll();

        $userCount = Users::select('COUNT(users.id) AS count');
        $userCount = $userCount->get();

        if ($page < 0 || $perPage * $page > ceil(($userCount->count / $perPage)) * $perPage) {
            return view('errors/error404');
        } else {
            return view('admin/users', ['users' => $users, 'page' => $page, 'pageCount' => ceil($userCount->count / $perPage)]);
        }
    }
}
