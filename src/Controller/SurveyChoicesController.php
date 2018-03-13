<?php
namespace Qobo\Survey\Controller;

use App\Controller\AppController;

/**
 * SurveyChoices Controller
 *
 * @property \Qobo\Survey\Model\Table\SurveyChoicesTable $SurveyChoices
 *
 * @method \Qobo\Survey\Model\Entity\SurveyChoice[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SurveyChoicesController extends AppController
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
        $surveyChoices = $this->paginate($this->SurveyChoices);

        $this->set(compact('surveyChoices'));
    }

    /**
     * View method
     *
     * @param string|null $id Survey Choice id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $surveyChoice = $this->SurveyChoices->get($id, [
            'contain' => ['SurveyQuestions']
        ]);

        $this->set('surveyChoice', $surveyChoice);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $surveyChoice = $this->SurveyChoices->newEntity();
        if ($this->request->is('post')) {
            $surveyChoice = $this->SurveyChoices->patchEntity($surveyChoice, $this->request->getData());
            if ($this->SurveyChoices->save($surveyChoice)) {
                $this->Flash->success(__('The survey choice has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The survey choice could not be saved. Please, try again.'));
        }
        $surveyQuestions = $this->SurveyChoices->SurveyQuestions->find('list', ['limit' => 200]);
        $this->set(compact('surveyChoice', 'surveyQuestions'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Survey Choice id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $surveyChoice = $this->SurveyChoices->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $surveyChoice = $this->SurveyChoices->patchEntity($surveyChoice, $this->request->getData());
            if ($this->SurveyChoices->save($surveyChoice)) {
                $this->Flash->success(__('The survey choice has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The survey choice could not be saved. Please, try again.'));
        }
        $surveyQuestions = $this->SurveyChoices->SurveyQuestions->find('list', ['limit' => 200]);
        $this->set(compact('surveyChoice', 'surveyQuestions'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Survey Choice id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $surveyChoice = $this->SurveyChoices->get($id);
        if ($this->SurveyChoices->delete($surveyChoice)) {
            $this->Flash->success(__('The survey choice has been deleted.'));
        } else {
            $this->Flash->error(__('The survey choice could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
