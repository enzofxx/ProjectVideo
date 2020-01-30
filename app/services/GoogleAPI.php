<?php

namespace App\Services;

use App\Core\Service;
use Google_Client;

class GoogleAPI {
    public $gClient, $redirect_uri;

    public function __construct()
    {
        $this->redirect_uri = 'http://localhost/ProjectVideo/public/google-callback';
        $this->gClient = new Google_Client();
        $this->gClient->setClientId("393711709519-ks05el214htlf4dijg12jfmph6gd9ul4.apps.googleusercontent.com");
        $this->gClient->setClientSecret("aIfJtcR0ERaRtG42cSH-7_ZI");
        $this->gClient->setApplicationName('Project Video');
        $this->gClient->addScope('profile email openid');
        $this->gClient->setRedirectUri($this->redirect_uri);
    }

    public function getLoginUrl()
    {
        return $this->gClient->createAuthUrl();

    }

    public function setSession () {
        $session = Service::get('session');
        if ( $session->has('access_token'))
            $this->gClient->setAccessToken($session->get('access_token'));
        else if (isset($_GET['code'])) {
            $token = $this->gClient->fetchAccessTokenWithAuthCode($_GET['code']);
            $session->set('access_token',$token);
        } else {
            var_dump('nepavyko su cookies');
            return;
        }

        $oAuth = new \Google_Service_Oauth2($this->gClient);
        $userData = $oAuth->userinfo_v2_me->get();
        $session->set('id',$userData['id']);
        $session->set('email',$userData['email']);
        $session->set('familyName',$userData['familyName']);
        $session->set('givenName',$userData['givenName']);
//        header('Location: gg');
//        exit();
    }

    public function revokeToken() {
        $this->gClient->revokeToken();
    }
}