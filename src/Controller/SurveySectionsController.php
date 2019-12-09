<?php
namespace Qobo\Survey\Controller;

use Cake\Datasource\EntityInterface;
use Cake\ORM\TableRegistry;
use Qobo\Survey\Controller\AppController;
use Webmozart\Assert\Assert;

/**
 * SurveySections Controller
 *
 * @property \Qobo\Survey\Model\Table\SurveySectionsTable $SurveySections
 * @property \Qobo\Survey\Model\Table\SurveysTable $Surveys
 * @property \Qobo\Survey\Model\Table\SurveyQuestionsTable $SurveyQuestions
 *
 * @method \Qobo\Survey\Model\Entity\SurveySection[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SurveySectionsController extends AppController
{
    protected $Surveys;

    protected $SurveyQuestions;

    /**
     * Initialize hook method
     *
     * @return void
     */
    public function initialize() : void
    {
        parent::initialize();

        /** @var \Qobo\Survey\Model\Table\SurveysTable $table */
        $table = TableRegistry::getTableLocator()->get('Qobo/Survey.Surveys');
        $this->Surveys = $table;

        /** @var \Qobo\Survey\Model\Table\SurveyQuestionsTable $table */
        $table = TableRegistry::getTableLocator()->get('Qobo/Survey.SurveyQuestions');
        $this->SurveyQuestions = $table;
    }

    /**
     * Add method
     * @param string $surveyId id of the survey
     *
     * @return \Cake\Http\Response|void|null Redirects on successful add, renders view otherwise.
     */
    public function add(string $surveyId)
    {
        $survey = $this->Surveys->getSurveyData($surveyId);
        Assert::isInstanceOf($survey, EntityInterface::class);

        $surveySection = $this->SurveySections->newEntity();

        if ($this->request->is(['post', 'put', 'patch'])) {
            $entity = $this->SurveySections->patchEntity($surveySection, (array)$this->request->getData());

            if ($this->SurveySections->save($entity)) {
                $this->Flash->success((string)__d('Qobo/Survey', 'The survey section has been saved.'));
            }

            return $this->redirect(['controller' => 'Surveys', 'action' => 'view', $surveyId]);
        }

        $this->set(compact('surveySection', 'survey'));
    }

    /**
     * Edit method
     *
     * @param string $surveyId survey id
     * @param string $id Survey Section id.
     *
     * @return \Cake\Http\Response|void|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(string $surveyId, string $id)
    {
        $survey = $this->Surveys->getSurveyData($surveyId);
        Assert::isInstanceOf($survey, EntityInterface::class);

        $surveySection = $this->SurveySections->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $entity = $this->SurveySections->patchEntity($surveySection, (array)$this->request->getData());

            if ($this->SurveySections->save($entity)) {
                $this->Flash->success((string)__d('Qobo/Survey', 'The survey section has been saved.'));
            }

            return $this->redirect(['controller' => 'Surveys', 'action' => 'view', $surveyId]);
        }

        $this->set(compact('surveySection', 'survey'));
    }

    /**
     * @param string $surveyId slug or ID of the survey
     * @param string $id of the section
     * @return \Cake\Http\Response|void|null Redirects to index.
     */
    public function view(string $surveyId, string $id)
    {
        $this->request->allowMethod(['get']);

        $survey = $this->Surveys->getSurveyData($surveyId);
        $questionTypes = $this->SurveyQuestions->getQuestionTypes();

        /** @var \Cake\ORM\Query $query */
        $query = $this->SurveySections->find()
            ->enableHydration(true)
            ->where([
                'id' => $id,
            ])
            ->contain(['SurveyQuestions']);

        $section = $query->first();
        Assert::isInstanceOf($section, EntityInterface::class);

        $this->set(compact('section', 'survey', 'questionTypes'));
    }

    /**
     * Delete method
     *
     * @param string $surveyId of the survey
     * @param string $id Survey Section id.
     * @return \Cake\Http\Response|void|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(string $surveyId, string $id)
    {
        $this->request->allowMethod(['post', 'delete']);

        $surveySection = $this->SurveySections->get($id);

        if ($this->SurveySections->delete($surveySection)) {
            $this->Flash->success((string)__d('Qobo/Survey', 'The survey section has been deleted.'));
        } else {
            $this->Flash->error((string)__d('Qobo/Survey', 'The survey section could not be deleted. Please, try again.'));
        }

        return $this->redirect(['controller' => 'Surveys', 'action' => 'view', $surveyId]);
    }
}
