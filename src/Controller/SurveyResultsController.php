<?php
namespace Qobo\Survey\Controller;

use Cake\ORM\TableRegistry;
use Qobo\Survey\Controller\AppController;

/**
 * SurveyResults Controller
 *
 * @property \Qobo\Survey\Model\Table\SurveyResultsTable $SurveyResults
 *
 * @method \Qobo\Survey\Model\Entity\SurveyResult[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SurveyResultsController extends AppController
{
    protected $Surveys;

    protected $SurveyEntries;

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

        $table = TableRegistry::getTableLocator()->get('Qobo/Survey.SurveyEntries');
        $this->SurveyEntries = $table;
    }

    /**
     * Edit submitted survey question with its survey results
     *
     * @param string $entryId of the survey
     * @param string $questionId of the survey
     *
     * @return \Cake\Http\Response|void|null
     */
    public function edit(string $entryId, string $questionId)
    {
        $surveyEntry = $this->SurveyEntries->get($entryId);
        $survey = $this->Surveys->get($surveyEntry->get('survey_id'));

        $this->set(compact('survey', 'surveyEntry'));
    }

    /**
     * Delete method
     *
     * @param string $id Survey Result id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(string $id)
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
