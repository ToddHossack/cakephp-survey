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
 * @property \Qobo\Survey\Model\Table\SurveyEntryQuestionsTable $SurveyEntryQuestions
 *
 * @method \Qobo\Survey\Model\Entity\SurveyEntry[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SurveyEntriesController extends AppController
{
    public $Surveys;

    public $SurveyResults;

    public $SurveyAnswers;

    public $SurveyEntryQuestions;

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

        $table = TableRegistry::getTableLocator()->get('Qobo/Survey.SurveyEntryQuestions');
        $this->SurveyEntryQuestions = $table;
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
            'contain' => [
                'SurveyEntryQuestions' =>
                [
                    'SurveyQuestions' => 'SurveyAnswers',
                    'SurveyResults',
                ],
            ],
        ]);

        $survey = $this->Surveys->find()
            ->where([
                'id' => $surveyEntry->get('survey_id'),
            ])
            ->contain(
                [
                    'SurveySections' => [
                        'SurveyQuestions' => 'SurveyAnswers',
                    ],
                ]
            )->first();

        $this->set(compact('surveyEntry', 'survey', 'entryStatuses'));
    }

    /**
     * Edit method
     *
     * @param string $id Survey Entry id.
     * @return \Cake\Http\Response|void|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(string $id)
    {
        $entryStatuses = $this->SurveyEntries->getStatuses();
        $surveyEntry = $this->SurveyEntries->get($id, [
            'contain' => [
                'SurveyEntryQuestions' =>
                [
                    'SurveyQuestions' => 'SurveyAnswers',
                    'SurveyResults',
                ],
            ],
        ]);

        $survey = $this->Surveys->find()
            ->where([
                'id' => $surveyEntry->get('survey_id'),
            ])
            ->contain(
                [
                    'SurveySections' => [
                        'SurveyQuestions' => 'SurveyAnswers',
                    ],
                ]
            )->first();

        if ($this->request->is(['post', 'put', 'patch'])) {
            $data = (array)$this->request->getData();
            if (!empty($data['SurveyEntryQuestions'])) {
                foreach ($data['SurveyEntryQuestions'] as $item) {
                    $entity = $this->SurveyEntryQuestions->get($item['id']);
                    $score = 0;
                    if ($item['status'] !== 'fail') {
                        $query = $this->SurveyResults->find()
                            ->where([
                                'survey_entry_question_id' => $item['id'],
                            ]);

                        if (!empty($query->count())) {
                            foreach ($query as $submit) {
                                $score += $submit->get('score');
                            }
                        }
                    }

                    $entity->set('score', $score);
                    $entity->set('status', $item['status']);
                    $saved = $this->SurveyEntryQuestions->save($entity);
                }
            }

            $data['SurveyEntries']['score'] = $surveyEntry->getTotalScore();
            $this->SurveyEntries->patchEntity($surveyEntry, $data['SurveyEntries']);

            $saved = $this->SurveyEntries->save($surveyEntry);
            if ($saved) {
                $this->Flash->success((string)__d('Qobo/Survey', 'Successfully updated survey results'));
            } else {
                $this->Flash->error((string)__d("Qobo/Survey", "Couldn't save updated survey results"));

                Log::error((string)json_encode($surveyEntry->getErrors(), JSON_PRETTY_PRINT));
            }

            return $this->redirect([
                'controller' => 'SurveyEntries',
                'action' => 'view',
                $surveyEntry->get('id'),
            ]);
        }

        $this->set(compact('surveyEntry', 'survey', 'entryStatuses'));
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
            $this->Flash->success((string)__d('Qobo/Survey', 'The survey entry has been deleted.'));
        } else {
            $this->Flash->error((string)__d('Qobo/Survey', 'The survey entry could not be deleted. Please, try again.'));
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
            $survey->get('id'),
        ]);
    }
}
