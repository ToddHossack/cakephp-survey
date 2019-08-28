<?php
namespace Qobo\Survey\Controller;

use Cake\Log\Log;
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

    public $SurveyAnswers;

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

        $table = TableRegistry::getTableLocator()->get('Qobo/Survey.SurveyAnswers');
        $this->SurveyAnswers = $table;
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
        $entryStatuses = $this->SurveyEntries->getStatuses();
        $surveyEntry = $this->SurveyEntries->get($id, [
            'contain' => ['SurveyResults'],
        ]);
        $survey = $this->Surveys->getSurveyData($surveyEntry->get('survey_id'), true);

        if ($this->request->is(['post', 'put', 'patch'])) {
            $data = (array)$this->request->getData();
            if (!empty($data['SurveyResults'])) {
                foreach ($data['SurveyResults'] as $item) {
                    $query = $this->SurveyResults->find()
                        ->where([
                            'submit_id' => $surveyEntry->get('id'),
                            'survey_question_id' => $item['survey_question_id']
                        ]);

                    if (empty($query->count())) {
                        continue;
                    }

                    foreach ($query as $entity) {
                        if ($item['status'] == 'fail') {
                            $entity->set('score', 0);
                        } else {
                            $answer = $this->SurveyAnswers->get($entity->get('survey_answer_id'));
                            $entity->set('score', $answer->get('score'));
                        }

                        $entity->set('status', $item['status']);
                        $this->SurveyResults->save($entity);
                    }
                }
            }

            $data['SurveyEntries']['score'] = $surveyEntry->getTotalScore();
            $this->SurveyEntries->patchEntity($surveyEntry, $data['SurveyEntries']);

            $saved = $this->SurveyEntries->save($surveyEntry);
            if ($saved) {
                $this->Flash->success((string)__('Successfully updated survey results'));
            } else {
                $this->Flash->error((string)__("Couldn't save updated survey results"));

                Log::error($surveyEntry->getErrors());
            }

            return $this->redirect([
                'controller' => 'Surveys',
                'action' => 'view',
                $survey->get('slug')
            ]);
        }

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
