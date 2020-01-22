<?php


namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Core\Config;
use App\Courses;
use App\Lectures;

class VideoStatsController extends Controller
{
    public function index()
    {

        $lectures = Lectures::select('*')->getAll();
        return view('admin/videostats',  ["lectures" => $lectures]);
    }
}
