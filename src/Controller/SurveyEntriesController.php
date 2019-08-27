<?php
namespace Qobo\Survey\Controller;

use Cake\ORM\TableRegistry;
use Qobo\Survey\Controller\AppController;

/**
 * SurveyEntries Controller
 *
 * @property \Qobo\Survey\Model\Table\SurveyEntriesTable $SurveyEntries
 * @property \Qobo\Survey\Model\Table\SurveyResultsTable $SurveyResults
 * @property \Qobo\Survey\Model\Table\SurveysTable $Surveys
 *
 * @method \Qobo\Survey\Model\Entity\SurveyEntry[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SurveyEntriesController extends AppController
{
    public $Surveys;

    public $SurveyResults;
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

        $table = TableRegistry::getTableLocator()->get('Qobo/Survey.SurveyResults');
        $this->SurveyResults = $table;
    }

    /**
     * View method
     *
     * @param string $id Survey Entry id.
     * @return \Cake\Http\Response|void|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(string $id)
    {
        $surveyEntry = $this->SurveyEntries->get($id, [
            'contain' => ['SurveyResults'],
        ]);
        $survey = $this->Surveys->getSurveyData($surveyEntry->get('survey_id'), true);
        $entryStatuses = $this->SurveyEntries->getStatuses();

        $this->set(compact('surveyEntry', 'survey', 'entryStatuses'));
    }

    /**
     * Edit method
     *
     * @param string $id Survey Entry id.
     * @return \Cake\Http\Response|void|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(string $id)
    {
        $surveyEntry = $this->SurveyEntries->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $surveyEntry = $this->SurveyEntries->patchEntity($surveyEntry, (array)$this->request->getData());
            if ($this->SurveyEntries->save($surveyEntry)) {
                $this->Flash->success((string)__('The survey entry has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error((string)__('The survey entry could not be saved. Please, try again.'));
        }
        $surveys = $this->SurveyEntries->Surveys->find('list');

        $this->set(compact('surveyEntry', 'surveys'));
    }

    /**
     * Delete method
     *
     * @param string $id Survey Entry id.
     * @return \Cake\Http\Response|void|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(string $id)
    {
        $this->request->allowMethod(['post', 'delete']);

        $surveyEntry = $this->SurveyEntries->get($id);
        $survey = $this->Surveys->get($surveyEntry->get('survey_id'));

        if ($this->SurveyEntries->delete($surveyEntry)) {
            $this->Flash->success((string)__('The survey entry has been deleted.'));
        } else {
            $this->Flash->error((string)__('The survey entry could not be deleted. Please, try again.'));
        }

        $query = $this->SurveyResults->find()
            ->where([
                'submit_id' => $id,
            ]);

        if (!empty($query->count())) {
            foreach ($query as $submit) {
                $this->SurveyResults->delete($submit);
            }
        }

        return $this->redirect([
            'controller' => 'Surveys',
            'action' => 'view',
            $survey->get('id')
        ]);
    }
}
