<?php
/**
 * Copyright (c) Qobo Ltd. (https://www.qobo.biz)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Qobo Ltd. (https://www.qobo.biz)
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace Qobo\Survey\Controller;

use App\Controller\AppController as BaseController;
use Cake\Log\Log;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;
use Exception;
use RuntimeException;

/**
 * @property \Qobo\Survey\Controller\Component\OrderComponent $Order
 */
class AppController extends BaseController
{
    /**
     * Initialization hook method.
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Qobo/Survey.Order');
    }

    /**
     * Change order of the record
     *
     * @param string $id of the instance
     * @param string $direction of the movement
     *
     * @return \Cake\Http\Response|void|null
     */
    public function move(string $id, string $direction)
    {
        return $this->Order->move($id, $direction);
    }
}
