<?php


namespace App\Controllers\Admin;

use App\Users;

class UserController
{
    public function index()
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