<?php
namespace Qobo\Survey\Controller;

use Cake\ORM\TableRegistry;
use Cake\ORM\Query;
use Qobo\Survey\Controller\AppController;
use Webmozart\Assert\Assert;

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

    protected $SurveyQuestions;

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

        $table = TableRegistry::getTableLocator()->get('Qobo/Survey.SurveyQuestions');
        $this->SurveyQuestions = $table;
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
        $result = [];
        $surveyEntry = $this->SurveyEntries->get($entryId);
        $survey = $this->Surveys->get($surveyEntry->get('survey_id'));

        $question = $this->SurveyQuestions->get($questionId, ['contain' => ['SurveyAnswers']]);

        $query = $this->SurveyResults->getQuestionResultsByEntryId($entryId, $questionId);
        Assert::isInstanceOf($query, Query::class);

        $submits = $query->all();

        if ($this->request->is(['post', 'put', 'patch'])) {
            $data = (array)$this->request->getData();
            foreach ($data['SurveyResults'] as $item) {
                $entity = $this->SurveyResults->get($item['id']);
                $entity->set('status', $item['status']);

                //if `failed` status of the submit, reset question submit score
                if ('failed' == $item['status']) {
                    $entity->set('score', 0);
                    $entity->set('comment', $item['comment']);
                } else {
                    $entity->set('score', $item['score']);
                }

                $saved = $this->SurveyResults->save($entity);
                if ($saved) {
                    $result[] = true;
                } else {
                    $result[] = $entity->getErrors();
                }
            }

            $this->Flash->success((string)__('Question Submit Status successfully saved'));

            return $this->redirect($this->referer());
        }

        $this->set(compact('survey', 'surveyEntry', 'question', 'submits'));
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
            $this->Flash->success((string)__('The survey result has been deleted.'));
        } else {
            $this->Flash->error((string)__('The survey result could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
