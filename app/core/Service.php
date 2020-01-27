<?php

namespace App\Core;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

class Service
{
    private static $container;

    public function __construct()
    {
        self::$container = new ContainerBuilder();
        $loader = new PhpFileLoader(self::$container, new FileLocator(__DIR__ . '/../services/'));
        $loader->load('servicesConfig.php');
        return self::$container;
    }

    public static function get($service = null)
    {
        if ($service === null) {
            return self::$container;
        }

        try {
            self::$container->get($service);
        } catch (ServiceNotFoundException $error) {
            $response = new Response;
            $response->send();
            die("No Service with name $service");
        }
        return self::$container->get($service);

    }

}