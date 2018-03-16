<?php

use Cake\Core\Configure;

$config = Configure::read('Survey');
if (empty($config)) {
    Configure::load('Qobo/Survey.survey', 'default');
}
