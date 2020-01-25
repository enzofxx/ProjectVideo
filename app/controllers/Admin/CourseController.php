<?php

namespace App\Controllers\Admin;
use App\Core\Support\Helpers\helpers;
use App\Controllers\Controller;
use App\Courses;
use App\Lectures;
use Symfony\Component\HttpFoundation\Request;

class CourseController extends Controller
{
    public function show($id)
    {
        $courseLectures = Lectures::select('lectures.*')->where('lectures.courseId', '=', $id)->getAll();
        if(!empty($courseLectures)) {
            return view('admin/showCourse', ['lectures' => $courseLectures, 'courseId'=>$id]);
        }
        else
            return view("errors/error404");
    }

    public function addCourse()
    {
        $lectures = Lectures::select('lectures.*')->limit(5)->getAll();
        return view('admin/addCourse', ['lectures' => $lectures]);
    }

    public function edit($courseId) {
        $course = Courses::select('*')->where('id', '=' ,$courseId)->get();
        return view('admin/editCourse',['course'=> $course]);
    }
    public function updateCourse(Request $request, $id) {
        $upload = $request->files->get('picture');
        $data = $request->request->all();

        if (!isset($data['name']) || !isset($data['about']) || !isset($data['price'])) {
            return view('errors/error404');
        } else {
            $query = [
                "name" => $data['name'],
                "about" => $data['about'],
                "price" => $data['price']
            ];
            if (isset($upload)) {
                checkForUploadErrors($upload);
                $query["picture"]= '../resources/uploads/' . $upload->getClientOriginalName();
            }

            if (strlen($query['name']) <= 0 || strlen($query['about']) <= 0 || strlen($query['price']) <= 0 ) {
                return view('errors/error404');
            }
            Courses::update($query, $id);

            if (isset($upload)) {
                $target_dir = dirname(__DIR__, 3) . '/resources/uploads/';
                $target_file = $target_dir.$upload->getClientOriginalName();
                move_uploaded_file($upload->getPathName(),$target_file);
            }
            return redirect('admin');
        }

    }
    public function storeCourse(Request $request)
    {
        $upload = $request->files->get('picture');
        checkForUploadErrors($upload);
        $data = $request->request->all();
        $target_dir = dirname(__DIR__, 3) . '/resources/uploads/';
        $target_file = $target_dir.$upload->getClientOriginalName();

        if (!isset($data['name']) || !isset($data['about']) || !isset($data['price']) || !isset($_FILES)) {
            return view('errors/error404');
        } else {
            $query = [
                "name" => $data['name'],
                "about" => $data['about'],
                "price" => $data['price'],
                "picture" => '../resources/uploads/' . $upload->getClientOriginalName(),
            ];

            if (strlen($query['name']) <= 0 || strlen($query['about']) <= 0 || strlen($query['price']) <= 0 ) {
                return view('errors/error404');
            }
            die('valio');
            Courses::insert($query);
            move_uploaded_file($upload->getPathName(),$target_file);
            $lecturesQuery = ["courseId" => get_object_vars(Courses::select('*')->max('id')->get())['MAX(id)'], "videoUrl" => 'https://www.youtube.com/embed/wjipJEho3EU'];
            Lectures::insert($lecturesQuery);
            return redirect('admin');
        }
    }

    public function addvideo()
    {
        return view('admin/addVideo');
    }

}
