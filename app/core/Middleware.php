<?php
namespace App\Core;

class Middleware
{
    public $response = true;

    public function __construct($middleware, $request)
    {

       if($middleware = 'roleAuth'){
           $this->roleAuth($request);
       } else {
           var_dump('No this type of middleware', $middleware);
           die();
       }

        return $this->response ;
    }

    public function roleAuth() {
        $this->response = true;
    }

}
