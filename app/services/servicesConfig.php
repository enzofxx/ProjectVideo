<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return function (ContainerConfigurator $configurator) {
    $configurator->parameters();
       // ->set('param.request', ref('foundationRequest'));


    $services = $configurator->services();

    $services->set('foundationRequest', 'Symfony\Component\HttpFoundation\Request')
        ->factory(['Symfony\Component\HttpFoundation\Request', 'createFromGlobals'])
        ->alias('request', 'foundationRequest')
        ->alias('Symfony\Component\HttpFoundation\Request', 'foundationRequest');


    $services->set('session', 'Symfony\Component\HttpFoundation\Session\Session')
        ->call('start');

    $services->set('paysera', 'App\Services\Paysera');

};
