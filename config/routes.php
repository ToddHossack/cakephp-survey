<?php
use Cake\Routing\Router;

Router::plugin(
    'Qobo/Survey',
    ['path' => '/surveys'],
    function ($routes) {
        $routes->extensions(['json']);

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
