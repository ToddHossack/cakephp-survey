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
        $surveySection = $this->SurveySections->newEntity();

        $survey = $this->Surveys->getSurveyData($surveyId);
        Assert::isInstanceOf($survey, EntityInterface::class);

        $query = $this->SurveyQuestions->find()
            ->where([
                'survey_id' => $survey->get('id')
            ]);
        $questions = $query->all();

        if ($this->request->is('post')) {
            $data = (array)$this->request->getData();

            $entity = $this->SurveySections->patchEntity($surveySection, $data);
            $saved = $this->SurveySections->save($entity);
            Assert::isInstanceOf($saved, EntityInterface::class);

            if (!empty($data['section_questions'])) {
                $items = [];
                foreach ($data['section_questions']['_ids'] as $id) {
                    $entity = $this->SurveyQuestions->get($id);
                    Assert::isInstanceOf($entity, EntityInterface::class);

                    $entity->set('survey_section_id', $saved->get('id'));
                    $items[] = $entity;
                }

                /** @var \Cake\ORM\ResultSet&iterable<\Cake\Datasource\EntityInterface> $entities */
                $entities = $items;
                $this->SurveyQuestions->saveMany($entities);
            }

            $this->Flash->success((string)__('The survey section has been saved.'));

            return $this->redirect(['controller' => 'Surveys', 'action' => 'view', $surveyId]);
        }

        $this->set(compact('surveySection', 'survey', 'questions'));
    }

    /**
     * Edit method
     *
     * @param string $surveyId survey id
     * @param string|null $id Survey Section id.
     *
     * @return \Cake\Http\Response|void|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(string $surveyId, ?string $id)
    {
        $survey = $this->Surveys->getSurveyData($surveyId);
        Assert::isInstanceOf($survey, EntityInterface::class);

        $surveySection = $this->SurveySections->get($id, [
            'contain' => ['SurveyQuestions']
        ]);

        $query = $this->SurveyQuestions->find()
            ->where([
                'survey_id' => $survey->get('id'),
            ]);
        $questions = $query->all();

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = (array)$this->request->getData();

            foreach ($surveySection->get('survey_questions') as $item) {
                $item->set('survey_section_id', null);
                $this->SurveyQuestions->save($item);
            }

            $entity = $this->SurveySections->patchEntity($surveySection, $data);
            $saved = $this->SurveySections->save($entity);
            Assert::isInstanceOf($saved, EntityInterface::class);

            if (!empty($data['section_questions'])) {
                $items = [];
                foreach ($data['section_questions']['_ids'] as $id) {
                    $entity = $this->SurveyQuestions->get($id);
                    Assert::isInstanceOf($entity, EntityInterface::class);

                    $entity->set('survey_section_id', $saved->get('id'));
                    $items[] = $entity;
                }

                /** @var \Cake\ORM\ResultSet&iterable<\Cake\Datasource\EntityInterface> $entities */
                $entities = $items;
                $this->SurveyQuestions->saveMany($entities);
            }

            $this->Flash->success((string)__('The survey section has been saved.'));

            return $this->redirect(['controller' => 'Surveys', 'action' => 'view', $surveyId]);
        }

        $this->set(compact('surveySection', 'survey', 'questions'));
    }

    /**
     * @return \Cake\Http\Response|void|null Redirects to index.
     */
    public function view(string $surveyId, string $id)
    {
        $this->request->allowMethod(['get']);

        $survey = $this->Surveys->getSurveyData($surveyId);
        $questionTypes = $this->SurveyQuestions->getQuestionTypes();
        $section = $this->SurveySections->find()
            ->enableHydration(true)
            ->where([
                'id' => $id,
            ])
            ->contain(['SurveyQuestions'])
            ->first();

        $this->set(compact('section', 'survey', 'questionTypes'));
    }

    /**
     * Delete method
     *
     * @param string $surveyId of the survey
     * @param string|null $id Survey Section id.
     * @return \Cake\Http\Response|void|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(string $surveyId, ?string $id)
    {
        $this->request->allowMethod(['post', 'delete']);

        $surveySection = $this->SurveySections->get($id);

        if ($this->SurveySections->delete($surveySection)) {
            $this->Flash->success((string)__('The survey section has been deleted.'));
        } else {
            $this->Flash->error((string)__('The survey section could not be deleted. Please, try again.'));
        }

        return $this->redirect(['controller' => 'Surveys', 'action' => 'view', $surveyId]);
    }
}
