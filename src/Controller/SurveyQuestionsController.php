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

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

class SurveyQuestionsController extends AppController
{
    /**
     * Initializing the controller
     * and also preload Surveys Table
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $this->Surveys = TableRegistry::get('Qobo/Survey.Surveys');
    }

    /**
     * Before Filter callback
     *
     * Preloading numerous vars for question methods
     *
     * @param \Cake\Event\Event $event broadcasted.
     * @return void
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        $questionTypes = $this->SurveyQuestions->getQuestionTypes();
        $this->set(compact('questionTypes'));
    }

    /**
     * View method
     *
     * @param string $surveyId of the survey or either its slug
     * @param string|null $id Survey Question id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($surveyId, $id = null)
    {
        $query = $this->SurveyQuestions->find();
        $query->where(['SurveyQuestions.id' => $id]);
        $query->contain([
            'Surveys',
            'SurveyAnswers' => [
                'sort' => ['SurveyAnswers.order' => 'ASC'],
            ]
        ]);

        $query->execute();
        $surveyQuestion = $query->first();

        $survey = $this->Surveys->getSurveyData($surveyId, false);

        $this->set(compact('surveyQuestion', 'survey'));
    }

    /**
     * View method
     *
     * @param string $surveyId of the survey or either its slug
     * @param string|null $id Survey Question id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function preview($surveyId, $id = null)
    {
        $savedResults = [];
        $surveyQuestion = $this->SurveyQuestions->get($id, [
            'contain' => ['Surveys', 'SurveyAnswers']
        ]);

        if ($this->request->is(['post', 'put', 'patch'])) {
            $savedResults = $this->request->getData();
        }

        $this->set(compact('surveyQuestion', 'savedResults'));
    }

    /**
     * Add method
     *
     * @param string $surveyId of the survey or either its slug
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($surveyId)
    {
        $surveyQuestion = $this->SurveyQuestions->newEntity();
        $survey = $this->Surveys->getSurveyData($surveyId);

        if ($this->request->is(['post', 'put', 'patch'])) {
            $surveyQuestion = $this->SurveyQuestions->patchEntity($surveyQuestion, $this->request->getData());
            if ($this->SurveyQuestions->save($surveyQuestion)) {
                $this->Flash->success(__('The survey question has been saved.'));

                return $this->redirect(['controller' => 'SurveyQuestions', 'action' => 'view', $surveyId, $surveyQuestion->id]);
            }
            $this->Flash->error(__('The survey question could not be saved. Please, try again.'));
        }

        $this->set(compact('surveyQuestion', 'survey'));
    }

    /**
     * Edit method
     *
     * @param string $surveyId of the survey or either its slug
     * @param string|null $id Survey Question id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($surveyId, $id = null)
    {
        $survey = $this->Surveys->getSurveyData($surveyId);
        $surveyQuestion = $this->SurveyQuestions->get($id);
        $redirect = ['controller' => 'Surveys', 'action' => 'view', $survey->id];

        if ($this->request->is(['patch', 'post', 'put'])) {
            $surveyQuestion = $this->SurveyQuestions->patchEntity($surveyQuestion, $this->request->getData());
            if ($this->SurveyQuestions->save($surveyQuestion)) {
                $this->Flash->success(__('The survey question has been saved.'));

                return $this->redirect($redirect);
            }
            $this->Flash->error(__('The survey question could not be saved. Please, try again.'));
        }

        $this->set(compact('surveyQuestion', 'survey'));
    }

    /**
     * Delete method
     *
     * @param string $surveyId of the survey or either its slug
     * @param string|null $id Survey Question id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($surveyId, $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $question = $this->SurveyQuestions->get($id);
        $survey = $this->Surveys->getSurveyData($surveyId);
        $surveyId = empty($survey->slug) ? $survey->id : $survey->slug;
        $redirect = ['controller' => 'Surveys', 'action' => 'view', $surveyId];

        if ($this->SurveyQuestions->delete($question)) {
            $this->Flash->success(__('The survey question has been deleted.'));
        } else {
            $this->Flash->error(__('The survey question could not be deleted. Please, try again.'));
        }

        return $this->redirect($redirect);
    }
}
