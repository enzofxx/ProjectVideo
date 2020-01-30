<?php

use App\Core\Router;

/*---- BackOffice ----*/
/* Index */
Router::get("/admin", "Admin\IndexController@index")->name('admin.index');

/* Course */
Router::get("/admin/course/add", "Admin\CourseController@addCourse")->name('admin.addCourse');
Router::put("/admin/course/add", "Admin\CourseController@storeCourse")->name('admin.storeCourse');
Router::get("/admin/course/{courseId}", "Admin\CourseController@show")->name('admin.showCourse');
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

/*---- FrontOffice ----*/
/* Login */
Router::post("", "Publics\PublicsController@login")->name('login');

/* Index */
Router::get("", "Publics\PublicsController@index")->name('home');
Router::get("/course/{course}", "CourseController@show")->name('course.show');
Router::get("/profile/{profile}", "UserController@profile")->name('user.profile');
Router::get("/profile/{profile}/payments", "UserController@payments")->name('user.payments');
Router::get("/profile/{profile}/payments/{payment}", "UserController@paymentShow")->name('user.payments.show');

/* About Us */
Router::get("/about", "Publics\PublicsController@about")->name('about');

/* Feedback */
Router::get("/feedback", "Publics\PublicsController@feedback")->name('feedback');

/* Courses */
Router::get("/course/{course}", "CourseController@show")->name('course.show');
Router::get("/course", "CourseController@index")->name('course.index');



/* EXAMPLES */

/* API */

/* DocTags */
//Router::get('/api/doctags', 'DocTagsController@doctags')->name('api.doctags.doctags'); Example route for DocTags axios ajax

/* End of EXAMPLES */
