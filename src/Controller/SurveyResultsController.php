<?php
namespace Qobo\Survey\Controller;


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
     * Initialize survey answers controller
     * pre-load Surveys table object
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
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
            $this->Flash->success((string)__d('Qobo/Survey', 'The survey result has been deleted.'));
        } else {
            $this->Flash->error((string)__d('Qobo/Survey', 'The survey result could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
