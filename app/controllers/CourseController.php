<?php

namespace App\Controllers;

use App\Core\Router;
use App\Core\Service;
use App\Courses;
use App\Lectures;
use App\Payments;

class CourseController extends controller
{
    public function index()
    {
        $payments = Payments::select('*')->getAll();
        $courses = Courses::select('*')->getAll();
        $user = Service::get('session')->get('user');

        array_walk($courses, function ($course) use (&$payments, $user) {
            array_walk($payments, function ($payment) use (&$course, $user) {
                if ($payment->userId == $user->id && $payment->productId == $course->id) {
                    $course->purchased = $payment;
                }
            });
        });

        return view('course/index', ['courses' => $courses]);
    }

    public function show($id)
    {
        $courses = Courses::select('*')->getAll();
        $payments = Payments::select('*')->getAll();
        $lecture = Lectures::select('lectures.*')->where('lectures.courseId', '=', $id)->getAll();
        $user = Service::get('session')->get('user');

        array_walk($courses, function ($course) use (&$payments, $user) {
            array_walk($payments, function ($payment) use (&$course, $user) {
                if ($payment->userId == $user->id && $payment->productId == $course->id) {
                    $course->purchased = $payment;
                }
            });
        });

        $purchases = Payments::select('*')->where('productId', '=', $id)->getAll();
        foreach ($purchases as $purchase) {
            if ($purchase->userId == $user->id && !empty($lecture)) {
                return view('course/show', ['lectures' => $lecture, 'courses' => $courses]);
            }
        }
        return view("errors/error404");
    }
}
