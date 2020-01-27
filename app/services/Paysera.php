<?php

namespace App\Services;

use App\Core\Config;

class Paysera
{

    public function pay($email, $amount)
    {
        try {
            $request = WebToPay::redirectToPayment([
                'projectid' => Config::get('paysera', 'projectid'),
                'sign_password' => Config::get('paysera', 'sign_password'),
                'orderid' => rand(1000000, 9999999),
                'amount' => $amount,
                'currency' => Config::get('paysera', 'currency'),
                'country' => Config::get('paysera', 'country'),
                'accepturl' => Config::get('paysera', 'accepturl'),
                'cancelurl' => Config::get('paysera', 'cancelurl'),
                'callbackurl' => Config::get('paysera', 'callbackurl'),
                'p_email' => $email,
                'test' => Config::get('paysera', 'test'),
            ]);
        } catch (WebToPayException $e) {
            var_dump($e);
            die('BLOGAI');
        }
    }

    public function getPayment()
    {
        try {
            $response = WebToPay::checkResponse($_GET, array(
                'projectid' => Config::get('paysera', 'projectid'),
                'sign_password' => Config::get('paysera', 'sign_password'),
            ));

            $orderId = $response['orderid'];
            $amount = $response['amount'];
            $currency = $response['currency'];
            $status = $response['status']; // gaunam 0, nepatvirtas
            //@todo: check, if order with $orderId is already approved (callback can be repeated several times)
            //@todo: check, if order amount and currency matches $amount and $currency
            //@todo: confirm order
            return [$orderId, $amount, $currency, $status];
        } catch (Exception $e) {
            echo get_class($e) . ': ' . $e->getMessage();
        }
    }
}
