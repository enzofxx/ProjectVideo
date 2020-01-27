<?php


namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Core\Config;
use App\Lectures;

class VideoStatsController extends Controller
{
    public function index()
    {
        $lectures = Lectures::select('*')->limit(5)->getAll();
        return view('admin/videostats',  ["lectures" => $lectures]);
    }

    public function userPagination()
    {
        $perPage = 5;
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

        if ($page >= 0) {
            $lectures = Lectures::select('lectures.*')->pagination($perPage, $page);
        }
        else{
            return view('errors/error404');
        }

        $lectures = $lectures->getAll();

        $lectureCount = Lectures::select('COUNT(lectures.id) AS count');
        $lectureCount = $lectureCount->get();

        if ($page < 0 || $perPage * $page > ceil(($lectureCount->count / $perPage)) * $perPage) {
            return view('errors/error404');
        } else {
            return view('admin/videostats', ['lectures' => $lectures, 'page' => $page, 'pageCount' => ceil($lectureCount->count / $perPage)]);
        }
    }
}
