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

use Cake\Datasource\EntityInterface;
use Cake\ORM\TableRegistry;
use Qobo\Survey\Controller\AppController;
use Webmozart\Assert\Assert;

/**
 * SurveyAnswers Controller
 *
 * @property \Qobo\Survey\Model\Table\SurveysTable $Surveys
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
        /**
         * @var \Qobo\Survey\Model\Table\SurveysTable $table
         */
        $table = TableRegistry::get('Qobo/Survey.Surveys');
        $this->Surveys = $table;
    }

    /**
     * View method
     *
     * @param string $surveyId it's either slug or survey id.
     * @param string $questionId id of an instance
     * @param string $id Survey Answer id.
     *
     * @return \Cake\Http\Response|void|null
     */
    public function view(string $surveyId, string $questionId, string $id)
    {
        $survey = $this->Surveys->getSurveyData($surveyId, false);
        $questionTypes = $this->SurveyAnswers->SurveyQuestions->getQuestionTypes();

        $surveyAnswer = $this->SurveyAnswers->get($id, [
            'contain' => ['SurveyQuestions', 'SurveyResults'],
        ]);

        $this->set(compact('surveyAnswer', 'survey', 'questionTypes'));
    }

    /**
     * Add method
     *
     * @param string $surveyId it's either slug or survey id.
     * @param string $questionId of related instance
     *
     * @throws \Cake\Datasource\Exception\RecordNotFoundException
     *
     * @return \Cake\Http\Response|void|null Redirects on successful add, renders view otherwise.
     */
    public function add(string $surveyId, string $questionId)
    {
        $survey = $this->Surveys->getSurveyData($surveyId);
        Assert::isInstanceOf($survey, EntityInterface::class);

        $surveyAnswer = $this->SurveyAnswers->newEntity();

        $question = $this->SurveyAnswers->SurveyQuestions->get($questionId);
        $redirect = ['controller' => 'SurveyQuestions', 'action' => 'view', $surveyId, $questionId];

        if ($this->request->is(['post', 'put', 'patch'])) {
            $surveyAnswer = $this->SurveyAnswers->patchEntity($surveyAnswer, (array)$this->request->getData());

            if ($this->SurveyAnswers->save($surveyAnswer)) {
                $this->Flash->success((string)__('The survey answer has been saved.'));

                return $this->redirect($redirect);
            }
        }

        $this->set(compact('surveyAnswer', 'survey', 'question'));
    }

    /**
     * Edit method
     *
     * @param string $surveyId it's either slug or survey id.
     * @param string $questionId of related question instance
     * @param string $id Survey Answer id.
     *
     * @throws \Cake\Datasource\Exception\RecordNotFoundException
     *
     * @return \Cake\Http\Response|void|null Redirects on successful edit, renders view otherwise.
     */
    public function edit(string $surveyId, string $questionId, string $id)
    {
        $survey = $this->Surveys->getSurveyData($surveyId);
        Assert::isInstanceOf($survey, EntityInterface::class);

        $surveyAnswer = $this->SurveyAnswers->get($id);

        $question = $this->SurveyAnswers->SurveyQuestions->get($questionId);
        $redirect = ['controller' => 'SurveyQuestions', 'action' => 'view', $surveyId, $questionId];

        if ($this->request->is(['patch', 'post', 'put'])) {
            $surveyAnswer = $this->SurveyAnswers->patchEntity($surveyAnswer, (array)$this->request->getData());

            if ($this->SurveyAnswers->save($surveyAnswer)) {
                $this->Flash->success((string)__('The survey answer has been saved.'));

                return $this->redirect($redirect);
            }
        }

        $this->set(compact('surveyAnswer', 'survey', 'question'));
    }

    /**
     * Delete method
     *
     * @param string $surveyId it's either slug or survey id.
     * @param string $questionId of related question id instance
     * @param string $id Survey Answer id.
     *
     * @return \Cake\Http\Response|void|null Redirects to index.
     */
    public function delete(string $surveyId, string $questionId, string $id)
    {
        $this->request->allowMethod(['post', 'delete']);

        $answer = $this->SurveyAnswers->get($id);
        Assert::isInstanceOf($answer, EntityInterface::class);

        $redirect = ['controller' => 'SurveyQuestions', 'action' => 'view', $surveyId, $questionId];

        if ($this->SurveyAnswers->delete($answer)) {
            $this->Flash->success((string)__('The survey answer has been deleted.'));
        }

        return $this->redirect($redirect);
    }
}
