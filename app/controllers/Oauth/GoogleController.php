<?php

namespace App\Controllers\Oauth;

use App\Controllers\Controller;
use App\Core\Service;

class GoogleController extends Controller {

    public function loginForm() {
        Service::get('googleAPI')->setSession();
        redirect()->render();
    }
    public function logout() {
        Service::get('googleAPI')->revokeToken();
        Service::get('session')->clear();
        redirect()->render();
    }
}
