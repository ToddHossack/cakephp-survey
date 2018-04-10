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
use Cake\ORM\TableRegistry;

/**
 * SurveyAnswers Controller
 *
 * @property \Qobo\Survey\Model\Table\SurveyAnswersTable $SurveyAnswers
 *
 * @method \Qobo\Survey\Model\Entity\SurveyAnswer[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SurveyAnswersController extends AppController
{
    /**
     * Initialize survey answers controller
     * pre-load Surveys table object
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $this->Surveys = TableRegistry::get('Qobo/Survey.Surveys');
    }
    /**
     * View method
     *
     * @param string $surveyId it's either slug or survey id.
     * @param string $questionId id of an instance
     * @param string|null $id Survey Answer id.
     *
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($surveyId, $questionId = null, $id = null)
    {
        $survey = $this->Surveys->getSurveyData($surveyId, false);
        $questionTypes = $this->SurveyAnswers->SurveyQuestions->getQuestionTypes();

        $surveyAnswer = $this->SurveyAnswers->get($id, [
            'contain' => ['SurveyQuestions', 'SurveyResults']
        ]);

        $this->set(compact('surveyAnswer', 'survey', 'questionTypes'));
    }

    /**
     * Add method
     *
     * @param string $surveyId it's either slug or survey id.
     * @param string $questionId of related instance
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($surveyId = null, $questionId = null)
    {
        $surveyAnswer = $this->SurveyAnswers->newEntity();
        $survey = $this->Surveys->getSurveyData($surveyId);
        $question = $this->SurveyAnswers->SurveyQuestions->get($questionId);
        $redirect = ['controller' => 'SurveyQuestions', 'action' => 'view', $surveyId, $questionId];

        if ($this->request->is(['post', 'put', 'patch'])) {
            $data = $this->request->getData();
            $data['survey_question_id'] = $questionId;
            $surveyAnswer = $this->SurveyAnswers->patchEntity($surveyAnswer, $data);

            if ($this->SurveyAnswers->save($surveyAnswer)) {
                $this->Flash->success(__('The survey answer has been saved.'));

                return $this->redirect($redirect);
            }
            $this->Flash->error(__('The survey answer could not be saved. Please, try again.'));
        }

        $this->set(compact('surveyAnswer', 'survey', 'question'));
    }

    /**
     * Edit method
     *
     * @param string $surveyId it's either slug or survey id.
     * @param string $questionId of related question instance
     * @param string|null $id Survey Answer id.
     *
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($surveyId, $questionId = null, $id = null)
    {
        $surveyAnswer = $this->SurveyAnswers->get($id);
        $survey = $this->Surveys->getSurveyData($surveyId);
        $question = $this->SurveyAnswers->SurveyQuestions->get($questionId);
        $redirect = ['controller' => 'SurveyQuestions', 'action' => 'view', $surveyId, $questionId];

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $data['survey_question_id'] = $questionId;

            $surveyAnswer = $this->SurveyAnswers->patchEntity($surveyAnswer, $data);
            if ($this->SurveyAnswers->save($surveyAnswer)) {
                $this->Flash->success(__('The survey answer has been saved.'));

                return $this->redirect($redirect);
            }
            $this->Flash->error(__('The survey answer could not be saved. Please, try again.'));
        }

        $this->set(compact('surveyAnswer', 'survey', 'question'));
    }

    /**
     * Delete method
     *
     * @param string $surveyId it's either slug or survey id.
     * @param string $questionId of related question id instance
     * @param string|null $id Survey Answer id.
     *
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($surveyId, $questionId = null, $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $answer = $this->SurveyAnswers->get($id);
        $survey = $this->Surveys->getSurveyData($surveyId);
        $redirect = ['controller' => 'SurveyQuestions', 'action' => 'view', $surveyId, $questionId];

        if ($this->SurveyAnswers->delete($answer)) {
            $this->Flash->success(__('The survey answer has been deleted.'));
        } else {
            $this->Flash->error(__('The survey answer could not be deleted. Please, try again.'));
        }

        return $this->redirect($redirect);
    }
}
