<?php
namespace Qobo\Survey\Controller;

use Cake\ORM\TableRegistry;
use Qobo\Survey\Controller\AppController;

/**
 * SurveyEntries Controller
 *
 * @property \Qobo\Survey\Model\Table\SurveyEntriesTable $SurveyEntries
 * @property \Qobo\Survey\Model\Table\SurveysTable $Surveys
 *
 * @method \Qobo\Survey\Model\Entity\SurveyEntry[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SurveyEntriesController extends AppController
{
    public $Surveys;

    /**
     * Initialize survey answers controller
     * pre-load Surveys table object
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $table = TableRegistry::getTableLocator()->get('Qobo/Survey.Surveys');
        $this->Surveys = $table;
    }


    /**
     * View method
     *
     * @param string|null $id Survey Entry id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $surveyEntry = $this->SurveyEntries->get($id, [
            'contain' => ['SurveyResults'],
        ]);
        $survey = $this->Surveys->getSurveyData($surveyEntry->get('survey_id'), true);
        $this->set(compact('surveyEntry', 'survey'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Survey Entry id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $surveyEntry = $this->SurveyEntries->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $surveyEntry = $this->SurveyEntries->patchEntity($surveyEntry, $this->request->getData());
            if ($this->SurveyEntries->save($surveyEntry)) {
                $this->Flash->success(__('The survey entry has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The survey entry could not be saved. Please, try again.'));
        }
        $surveys = $this->SurveyEntries->Surveys->find('list', ['limit' => 200]);
        $this->set(compact('surveyEntry', 'surveys'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Survey Entry id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $surveyEntry = $this->SurveyEntries->get($id);
        if ($this->SurveyEntries->delete($surveyEntry)) {
            $this->Flash->success(__('The survey entry has been deleted.'));
        } else {
            $this->Flash->error(__('The survey entry could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
