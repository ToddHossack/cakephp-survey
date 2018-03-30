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
     * @param string|null $id Survey Answer id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($surveyId, $id = null)
    {
        $survey = $this->Surveys->getSurveyData($surveyId, false);

        $surveyAnswer = $this->SurveyAnswers->get($id, [
            'contain' => ['SurveyQuestions', 'SurveyResults']
        ]);

        $this->set(compact('surveyAnswer', 'survey'));
    }

    /**
     * Add method
     *
     * @param string $surveyId it's either slug or survey id.
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($surveyId = null)
    {
        $surveyAnswer = $this->SurveyAnswers->newEntity();
        $survey = $this->Surveys->getSurveyData($surveyId);

        if ($this->request->is(['post', 'put', 'patch'])) {
            $surveyAnswer = $this->SurveyAnswers->patchEntity($surveyAnswer, $this->request->getData());
            if ($this->SurveyAnswers->save($surveyAnswer)) {
                $this->Flash->success(__('The survey answer has been saved.'));

                return $this->redirect(['controller' => 'Surveys', 'action' => 'view', $survey->id]);
            }
            $this->Flash->error(__('The survey answer could not be saved. Please, try again.'));
        }

        $surveyQuestions = $this->SurveyAnswers->SurveyQuestions->getQuestionList($survey->id);
        $this->set(compact('surveyAnswer', 'surveyQuestions'));
    }

    /**
     * Edit method
     *
     * @param string $surveyId it's either slug or survey id.
     * @param string|null $id Survey Answer id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($surveyId, $id = null)
    {
        $surveyAnswer = $this->SurveyAnswers->get($id);
        $survey = $this->Surveys->getSurveyData($surveyId);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $surveyAnswer = $this->SurveyAnswers->patchEntity($surveyAnswer, $this->request->getData());
            if ($this->SurveyAnswers->save($surveyAnswer)) {
                $this->Flash->success(__('The survey answer has been saved.'));

                return $this->redirect(['controller' => 'Surveys', 'action' => 'view', $survey->id]);
            }
            $this->Flash->error(__('The survey answer could not be saved. Please, try again.'));
        }

        $surveyQuestions = $this->SurveyAnswers->SurveyQuestions->getQuestionList($survey->id);
        $this->set(compact('surveyAnswer', 'surveyQuestions'));
    }

    /**
     * Delete method
     *
     * @param string $surveyId it's either slug or survey id.
     * @param string|null $id Survey Answer id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($surveyId, $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $surveyAnswer = $this->SurveyAnswers->get($id);
        $survey = $this->Surveys->getSurveyData($surveyId);

        if ($this->SurveyAnswers->delete($surveyAnswer)) {
            $this->Flash->success(__('The survey answer has been deleted.'));
        } else {
            $this->Flash->error(__('The survey answer could not be deleted. Please, try again.'));
        }

        return $this->redirect(['controller' => 'Surveys', 'action' => 'view', $survey->id]);
    }
}
