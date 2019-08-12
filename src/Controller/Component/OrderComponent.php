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
namespace Qobo\Survey\Controller\Component;

use Cake\Controller\Component;
use Cake\Log\Log;
use Cake\ORM\TableRegistry;
use Exception;
use RuntimeException;

class OrderComponent extends Component
{
    const DIRECTION_UP = 'up';
    const DIRECTION_DOWN = 'down';

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
        /**
         * @var \Qobo\Survey\Model\Table\SurveysTable
         */

        $table = TableRegistry::getTableLocator()->get('Qobo/Survey.' . $this->getController()->getName());
        $direction = strtolower($direction);

        try {
            $entity = $table->get($id);

            if (self::DIRECTION_UP == $direction) {
                $table->moveUp($entity);
            }

            if (self::DIRECTION_DOWN == $direction) {
                $table->moveDown($entity);
            }
        } catch (Exception $e) {
            Log::warning($e->getMessage());
            throw new RuntimeException("Couldn't move entity record", 0, $e);
        }

        return $this->getController()->redirect($this->getController()->referer());
    }
}
