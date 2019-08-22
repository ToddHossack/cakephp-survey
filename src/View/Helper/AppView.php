<?php
namespace Qobo\Survey\View;

use Cake\View\View;

class AppView extends View
{
    public function initialize()
    {
        parent::initialize();
        $this->loadHelper('Qobo/Survey.Survey');
    }
}
