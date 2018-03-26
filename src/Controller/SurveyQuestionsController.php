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

/**
 * SurveyQuestions Controller
 *
 * @property \Qobo\Survey\Model\Table\SurveyQuestionsTable $SurveyQuestions
 *
 * @method \Qobo\Survey\Model\Entity\SurveyQuestion[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SurveyQuestionsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Surveys']
        ];
        $surveyQuestions = $this->paginate($this->SurveyQuestions);
        $questionTypes = $this->SurveyQuestions->getQuestionTypes();

        $this->set(compact('surveyQuestions', 'questionTypes'));
    }

    /**
     * View method
     *
     * @param string|null $id Survey Question id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $questionTypes = $this->SurveyQuestions->getQuestionTypes();
        $surveyQuestion = $this->SurveyQuestions->get($id, [
            'contain' => ['Surveys']
        ]);
        $this->set(compact('surveyQuestion', 'questionTypes'));
    }

    /**
     * View method
     *
     * @param string|null $id Survey Question id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function preview($id = null)
    {
        $questionTypes = $this->SurveyQuestions->getQuestionTypes();
        $savedResults = [];
        $surveyQuestion = $this->SurveyQuestions->get($id, [
            'contain' => ['Surveys', 'SurveyAnswers']
        ]);

        if ($this->request->is(['post', 'put', 'patch'])) {
            $savedResults = $this->request->getData();
        }

        $this->set(compact('surveyQuestion', 'questionTypes', 'savedResults'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $questionTypes = $this->SurveyQuestions->getQuestionTypes();

        $surveyQuestion = $this->SurveyQuestions->newEntity();
        if ($this->request->is('post')) {
            $surveyQuestion = $this->SurveyQuestions->patchEntity($surveyQuestion, $this->request->getData());
            if ($this->SurveyQuestions->save($surveyQuestion)) {
                $this->Flash->success(__('The survey question has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The survey question could not be saved. Please, try again.'));
        }
        $surveys = $this->SurveyQuestions->Surveys->find('list', ['limit' => 200]);
        $this->set(compact('surveyQuestion', 'surveys', 'questionTypes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Survey Question id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $questionTypes = $this->SurveyQuestions->getQuestionTypes();
        $surveyQuestion = $this->SurveyQuestions->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $surveyQuestion = $this->SurveyQuestions->patchEntity($surveyQuestion, $this->request->getData());
            if ($this->SurveyQuestions->save($surveyQuestion)) {
                $this->Flash->success(__('The survey question has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The survey question could not be saved. Please, try again.'));
        }
        $surveys = $this->SurveyQuestions->Surveys->find('list', ['limit' => 200]);
        $this->set(compact('surveyQuestion', 'surveys', 'questionTypes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Survey Question id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $surveyQuestion = $this->SurveyQuestions->get($id);
        if ($this->SurveyQuestions->delete($surveyQuestion)) {
            $this->Flash->success(__('The survey question has been deleted.'));
        } else {
            $this->Flash->error(__('The survey question could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
