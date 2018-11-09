<?php
namespace Qobo\Survey\Test\App\Config;

use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::defaultRouteClass(DashedRoute::class);

Router::connect('/:controller/:action/*');
Router::plugin(
    'Qobo/Survey',
    ['path' => '/surveys'],
    function ($routes) {
        $routes->setExtensions(['json']);

        $routes->scope('/survey', function ($routes) {
            $routes->connect(
                '/:slug/questions/:action/*',
                ['controller' => 'SurveyQuestions'],
                ['pass' => ['slug']]
            );

            $routes->connect(
                '/:slug/answers/:action/*',
                ['controller' => 'SurveyAnswers'],
                ['pass' => ['slug']]
            );

            $routes->connect(
                '/:slug/results/:action/*',
                ['controller' => 'SurveyResults'],
                ['pass' => ['slug']]
            );
        });
        $routes->fallbacks('DashedRoute');
    }
);
