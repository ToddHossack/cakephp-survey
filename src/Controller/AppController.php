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

class AppController extends BaseController
{
    const DIRECTION_UP = 'up';
    const DIRECTION_DOWN = 'down';

    /**
     * @{inheritDoc}
     */
    public function initialize()
    {
        parent::initialize();
    }

    /**
     * Change order of the record
     *
     * @param uuid $id of the instance
     * @param string $direction of the movement
     *
     * @return \Cake\Network\Response
     */
    public function move($id, $direction)
    {
        $table = TableRegistry::get('Qobo/Survey.' . $this->name);
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
        }

        return $this->redirect($this->referer());
    }

    /**
     * Sort records sequentially
     *
     * @param mixed $surveyId slug|id of the survey
     * @param uuid $parentId of parent module like SurveyQuestions to sort answer options
     *
     * @return \Cake\Network\Response
     */
    public function sort($surveyId, $parentId = null)
    {
        $sorted = false;

        if (!in_array($this->name, ['Surveys', 'SurveyQuestions'])) {
            throw new Exception(__('Sort method is not available in this Controller'));
        }

        if ('Surveys' == $this->name) {
            $survey = $this->Surveys->getSurveyData($surveyId);

            $name = 'Qobo/Survey.SurveyQuestions';
            $conditions = ['survey_id' => $survey->id];
        }

        if ('SurveyQuestions' == $this->name) {
            $name = 'Qobo/Survey.SurveyAnswers';
            $conditions = ['survey_question_id' => $parentId];
        }

        $table = TableRegistry::get($name);

        $query = $table->find()
            ->where($conditions)
            ->order(['order' => 'ASC']);

        $entities = $query->all()->toArray();

        if (!empty($entities)) {
            $sorted = $table->setOrder($entities);
        }

        if ($sorted) {
            $this->Flash->success(__('Records were successfully sorted'));
        } else {
            $this->Flash->error(__('Couldn\'t sort records. Please try again'));
        }

        return $this->redirect($this->referer());
    }
}
