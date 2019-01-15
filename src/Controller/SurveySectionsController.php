<?php
namespace Qobo\Survey\Controller;

use Qobo\Survey\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * SurveySections Controller
 *
 * @property \Qobo\Survey\Model\Table\SurveySectionsTable $SurveySections
 *
 * @method \Qobo\Survey\Model\Entity\SurveySection[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SurveySectionsController extends AppController
{
    public function initialize(): void
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
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Surveys']
        ];
        $surveySections = $this->paginate($this->SurveySections);

        $this->set(compact('surveySections'));
    }

    /**
     * View method
     *
     * @param string|null $id Survey Section id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $surveySection = $this->SurveySections->get($id, [
            'contain' => ['Surveys']
        ]);

        $this->set('surveySection', $surveySection);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add(string $surveyId)
    {
        $surveySection = $this->SurveySections->newEntity();
        $survey = $this->Surveys->getSurveyData($surveyId);

        $query = $this->SurveyQuestions->find()
            ->where([
                'survey_id' => $survey->get('id')
            ]);
        $questions = $query->all();

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            $data['survey_questions'] = $this->SurveySections->getJoinTableIds($data);

            $entity = $this->SurveySections->patchEntity($surveySection, $data, ['associated' => 'SurveyQuestions']);

            if ($this->SurveySections->save($entity)) {
                $this->Flash->success(__('The survey section has been saved.'));

                return $this->redirect(['controller' => 'Surveys', 'action' => 'view', $surveyId]);
            }
            $this->Flash->error(__('The survey section could not be saved. Please, try again.'));
        }
        $surveys = $this->SurveySections->Surveys->find('list', ['limit' => 200]);
        $this->set(compact('surveySection', 'survey', 'questions'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Survey Section id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(string $surveyId, ?string $id)
    {
        $survey = $this->Surveys->getSurveyData($surveyId);
        $surveySection = $this->SurveySections->get($id, [
            'contain' => ['SurveyQuestions']
        ]);

        $query = $this->SurveyQuestions->find()
            ->where([
                'survey_id' => $survey->get('id')
            ]);
        $questions = $query->all();

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $data['survey_questions'] = $this->SurveySections->getJoinTableIds($data);

            $entity = $this->SurveySections->patchEntity($surveySection, $data, ['associated' => 'SurveyQuestions']);

            if ($this->SurveySections->save($entity)) {
                $this->Flash->success(__('The survey section has been saved.'));

                return $this->redirect(['controller' => 'Surveys', 'action' => 'view', $surveyId]);
            }
            $this->Flash->error(__('The survey section could not be saved. Please, try again.'));
        }
        $surveys = $this->SurveySections->Surveys->find('list', ['limit' => 200]);
        $this->set(compact('surveySection', 'survey', 'questions'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Survey Section id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $surveySection = $this->SurveySections->get($id);
        if ($this->SurveySections->delete($surveySection)) {
            $this->Flash->success(__('The survey section has been deleted.'));
        } else {
            $this->Flash->error(__('The survey section could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
