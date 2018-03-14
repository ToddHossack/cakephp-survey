<?php
use Cake\Routing\Router;

Router::plugin(
    'Qobo/Survey',
    ['path' => '/surveys'],
    function ($routes) {
        $routes->fallbacks('DashedRoute');
    }
);
