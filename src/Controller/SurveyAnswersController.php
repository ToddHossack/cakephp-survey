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
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['SurveyQuestions']
        ];
        $surveyAnswers = $this->paginate($this->SurveyAnswers);

        $this->set(compact('surveyAnswers'));
    }

    /**
     * View method
     *
     * @param string|null $id Survey Answer id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $surveyAnswer = $this->SurveyAnswers->get($id, [
            'contain' => ['SurveyQuestions', 'SurveyResults']
        ]);

        $this->set('surveyAnswer', $surveyAnswer);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $surveyAnswer = $this->SurveyAnswers->newEntity();
        if ($this->request->is('post')) {

            $surveyAnswer = $this->SurveyAnswers->patchEntity($surveyAnswer, $this->request->getData());
            if ($this->SurveyAnswers->save($surveyAnswer)) {
                $this->Flash->success(__('The survey answer has been saved.'));

                $questionsTable = TableRegistry::get('Qobo/Survey.SurveyQuestions');
                $question = $questionsTable->get($this->request->data['survey_question_id']);

                $url = ['controller' => 'Surveys', 'action' => 'view', $question->survey_id];

                return $this->redirect($url);
            }
            $this->Flash->error(__('The survey answer could not be saved. Please, try again.'));
        }
        $surveyQuestions = $this->SurveyAnswers->SurveyQuestions->find('list', ['limit' => 200, 'keyField' => 'id', 'valueField' => 'question']);
        $this->set(compact('surveyAnswer', 'surveyQuestions'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Survey Answer id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $surveyAnswer = $this->SurveyAnswers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $surveyAnswer = $this->SurveyAnswers->patchEntity($surveyAnswer, $this->request->getData());
            if ($this->SurveyAnswers->save($surveyAnswer)) {
                $this->Flash->success(__('The survey answer has been saved.'));

                $questionsTable = TableRegistry::get('Qobo/Survey.SurveyQuestions');
                $question = $questionsTable->get($this->request->data['survey_question_id']);

                $url = ['controller' => 'Surveys', 'action' => 'view', $question->survey_id];

                return $this->redirect($url);
            }
            $this->Flash->error(__('The survey answer could not be saved. Please, try again.'));
        }
        $surveyQuestions = $this->SurveyAnswers->SurveyQuestions->find('list', ['limit' => 200, 'keyField' => 'id', 'valueField' => 'question']);
        $this->set(compact('surveyAnswer', 'surveyQuestions'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Survey Answer id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $surveyAnswer = $this->SurveyAnswers->get($id);
        if ($this->SurveyAnswers->delete($surveyAnswer)) {
            $this->Flash->success(__('The survey answer has been deleted.'));
        } else {
            $this->Flash->error(__('The survey answer could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
