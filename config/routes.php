<?php

use App\Core\Router;
use App\Core\Service;

$currentUSer = Service::get('session')->get('user')->role ?? null;


////////////////////////////// ONLY ADMIN ROUTES////////////////////
if($currentUSer == 'admin') {
    /*---- BackOffice ----*/
    /* Index */
    Router::get("/admin", "Admin\IndexController@index")->name('admin.index');

    /* Course */
    Router::get("/admin/course/add", "Admin\CourseController@addCourse")->name('admin.addCourse');
    Router::put("/admin/course/add", "Admin\CourseController@storeCourse")->name('admin.storeCourse');
    Router::get("/admin/course/{courseId}/edit", "Admin\CourseController@edit")->name('admin.editCourse');
    Router::patch("/admin/course/{courseId}/edit", "Admin\CourseController@updateCourse")->name('admin.updateCourse');
    Router::get("/admin/addvideo", "Admin\CourseController@addvideo")->name('admin.addVideo');

    /* Users */
    Router::get("/admin/user", "Admin\UserController@index")->name('admin.user');
    Router::get("admin/user/page", "Admin\UserController@userPagination")->name('admin.user.page');

    /* Video Statistics */
    Router::get("/admin/videostats", "Admin\VideoStatsController@index")->name('admin.videostats');
    Router::get("admin/videostats/page", "Admin\VideoStatsController@userPagination")->name('admin.videostats.page');

    /* Income */
    Router::get("/admin/income", "Admin\IncomeController@index")->name('admin.income');
}



////////////////////////// ONLY PUBLIC ROUTES////////////////////////////////////////
/* Login */
Router::post("", "Publics\PublicsController@login")->name('login');
/* logaut */
Router::get("/logout", "Publics\PublicsController@logout")->name('logout');
/* Index */
Router::get("", "Publics\PublicsController@index")->name('home');
/* Google oAuth API */
Router::get("/google-callback", "Oauth\GoogleController@loginForm")->name('course.gg');
Router::get("nesvarbu", "Oauth\GoogleController@logout")->name('google.logout');




////////////////////////////// ONLY LOGINED USSERS ROUTES //////////////////////////////////////
if($currentUSer == 'admin' || $currentUSer == 'user'){
    Router::get("/course/{course}", "CourseController@show")->name('course.show');
    Router::get("/profile", "UserController@profile")->name('user.profile');
    Router::get("/profile/{payment}", "UserController@paymentShow")->name('user.payments.show');

    /* About Us */
    Router::get("/about", "Publics\PublicsController@about")->name('about');

    /* Feedback */
    Router::get("/feedback", "Publics\PublicsController@feedback")->name('feedback');

    /* Courses */
    Router::get("/course/{course}", "CourseController@show")->name('course.show');
    Router::get("/course", "CourseController@index")->name('course.index');

}



/* EXAMPLES */

/* API */

/* DocTags */
//Router::get('/api/doctags', 'DocTagsController@doctags')->name('api.doctags.doctags'); Example route for DocTags axios ajax

/* End of EXAMPLES */
