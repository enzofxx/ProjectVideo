<?php
namespace App\Controllers\Purchases;

use App\Core\Config;
use App\Core\Service;
use App\Courses;
use App\Users;
use App\Payments;
use Symfony\Component\HttpFoundation\Request;

class PurchaseController
{
    public function register()
    {
        return view('purchase/register');
    }

    public function store(Request $request){
        $data = $request->request->all();
        if (!isset($data['name']) || !isset($data['surname']) || !isset($data['email']) || !isset($data['password'])
            || !isset($data['secondpassword'])) {
            return view('errors/error404');
        } else {
            $query = [
                "name" => $data['name'],
                "surname" => $data['surname'],
                "email" => $data['email'],
                "password" => $data['password'],
            ];

            if (strlen($query['name']) <= 0 || strlen($query['surname']) <= 0 || strlen($query['email']) <= 0  || strlen($query['password']) <= 0 ) {
                return view('errors/error404');
            }
            $userId = Users::insert($query);
            $courseId = Courses::select('id', 'name')->orderBy('id', 'Desc')->limit('1')->get();
            $courseId->id;
            for($i=1; $i<=$courseId->id; $i++){
                $query1 = ["userId" => $userId, "productId" => $i, "price" => 0];
                if ($i==$courseId->id){
                    $query1 = ["userId" => $userId, "productId" => $i, "price" => 91];
                }
                Payments::insert($query1);
            }
            $courses = Courses::select('*')->getAll();
            return view('public/index', ['courses' => $courses]);
        }
    }
}
