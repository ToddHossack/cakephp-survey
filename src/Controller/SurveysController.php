<?php
namespace Qobo\Survey\Controller;

use App\Controller\AppController;
use Cake\I18n\Date;

/**
 * Surveys Controller
 *
 * @property \Qobo\Survey\Model\Table\SurveysTable $Surveys
 *
 * @method \Qobo\Survey\Model\Entity\Survey[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SurveysController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $surveys = $this->paginate($this->Surveys);
        $categories = $this->Surveys->getSurveyCategories();

        $this->set(compact('surveys', 'categories'));
    }

    /**
     * View method
     *
     * @param string|null $id Survey id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $survey = $this->Surveys->get($id, [
            'contain' => []
        ]);

        $this->set('survey', $survey);
    }

    /**
     * Publish method
     *
     * @param string|null $id Survey id.
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function publish($id = null)
    {
        $survey = $this->Surveys->get($id);

        if ($this->request->is(['post', 'put', 'patch'])) {
            $data = $this->request->getData();

            $survey = $this->Surveys->patchEntity($survey, $data, ['validate' => false]);
            if ($this->Surveys->save($survey)) {
                $this->Flash->success(__('Survey was successfully saved.'));

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('Couldn\'t publish the survey'));
        }

        $this->set(compact('survey'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $survey = $this->Surveys->newEntity();
        $categories = $this->Surveys->getSurveyCategories();

        if ($this->request->is('post')) {
            $survey = $this->Surveys->patchEntity($survey, $this->request->getData());
            if ($this->Surveys->save($survey)) {
                $this->Flash->success(__('The survey has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The survey could not be saved. Please, try again.'));
        }
        $this->set(compact('survey', 'categories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Survey id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $categories = $this->Surveys->getSurveyCategories();
        $survey = $this->Surveys->get($id, [
            'contain' => []
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $survey = $this->Surveys->patchEntity($survey, $this->request->getData());
            if ($this->Surveys->save($survey)) {
                $this->Flash->success(__('The survey has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The survey could not be saved. Please, try again.'));
        }
        $this->set(compact('survey', 'categories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Survey id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $survey = $this->Surveys->get($id);
        if ($this->Surveys->delete($survey)) {
            $this->Flash->success(__('The survey has been deleted.'));
        } else {
            $this->Flash->error(__('The survey could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
