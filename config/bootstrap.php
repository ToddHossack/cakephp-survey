<?php

use Cake\Core\Configure;

$config = Configure::read('Survey');
if (empty($config)) {
    Configure::load('Qobo/Survey.survey', 'default');
}

/**
 * TinyMCE configuration
 */
$config = Configure::read('TinyMCE');
$config = $config ? $config : [];
Configure::load('Qobo/Survey.tinymce');
Configure::write('TinyMCE', array_replace_recursive(
    Configure::read('TinyMCE'),
    $config
));
