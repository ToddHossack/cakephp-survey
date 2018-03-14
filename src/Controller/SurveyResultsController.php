<?php
namespace Qobo\Survey\Controller;

use App\Controller\AppController;

/**
 * SurveyResults Controller
 *
 * @property \Qobo\Survey\Model\Table\SurveyResultsTable $SurveyResults
 *
 * @method \Qobo\Survey\Model\Entity\SurveyResult[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SurveyResultsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Surveys', 'SurveyQuestions', 'SurveyAnswers', 'Users']
        ];
        $surveyResults = $this->paginate($this->SurveyResults);

        $this->set(compact('surveyResults'));
    }

    /**
     * View method
     *
     * @param string|null $id Survey Result id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $surveyResult = $this->SurveyResults->get($id, [
            'contain' => ['Surveys', 'SurveyQuestions', 'SurveyAnswers', 'Users']
        ]);

        $this->set('surveyResult', $surveyResult);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $surveyResult = $this->SurveyResults->newEntity();
        if ($this->request->is('post')) {
            $surveyResult = $this->SurveyResults->patchEntity($surveyResult, $this->request->getData());
            if ($this->SurveyResults->save($surveyResult)) {
                $this->Flash->success(__('The survey result has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The survey result could not be saved. Please, try again.'));
        }
        $surveys = $this->SurveyResults->Surveys->find('list', ['limit' => 200]);
        $surveyQuestions = $this->SurveyResults->SurveyQuestions->find('list', ['limit' => 200]);
        $surveyAnswers = $this->SurveyResults->SurveyAnswers->find('list', ['limit' => 200]);
        $users = $this->SurveyResults->Users->find('list', ['limit' => 200]);
        $this->set(compact('surveyResult', 'surveys', 'surveyQuestions', 'surveyAnswers', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Survey Result id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $surveyResult = $this->SurveyResults->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $surveyResult = $this->SurveyResults->patchEntity($surveyResult, $this->request->getData());
            if ($this->SurveyResults->save($surveyResult)) {
                $this->Flash->success(__('The survey result has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The survey result could not be saved. Please, try again.'));
        }
        $surveys = $this->SurveyResults->Surveys->find('list', ['limit' => 200]);
        $surveyQuestions = $this->SurveyResults->SurveyQuestions->find('list', ['limit' => 200]);
        $surveyAnswers = $this->SurveyResults->SurveyAnswers->find('list', ['limit' => 200]);
        $users = $this->SurveyResults->Users->find('list', ['limit' => 200]);
        $this->set(compact('surveyResult', 'surveys', 'surveyQuestions', 'surveyAnswers', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Survey Result id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $surveyResult = $this->SurveyResults->get($id);
        if ($this->SurveyResults->delete($surveyResult)) {
            $this->Flash->success(__('The survey result has been deleted.'));
        } else {
            $this->Flash->error(__('The survey result could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
