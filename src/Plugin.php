<?php
namespace Qobo\Survey;

use Cake\Core\BasePlugin;
use Cake\Core\PluginApplicationInterface;
use Cake\Core\Configure;

class Plugin extends BasePlugin
{
    
    public function bootstrap(PluginApplicationInterface $app)
    {
        parent::bootstrap($app);
        
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
    }
    
    public function routes($routes)
    {
        parent::routes($routes);
    }

}