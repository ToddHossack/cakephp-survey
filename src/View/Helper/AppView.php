<?php
namespace Qobo\Survey\View\Helper;

use Cake\View\View;

class AppView extends View
{
    /**
     * @{inheritDoc}
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadHelper('Qobo/Survey.Survey');
    }
}
