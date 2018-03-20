<?php
namespace Qobo\Survey\Controller;

use App\Controller\AppController;
use Cake\I18n\Date;
use Cake\ORM\TableRegistry;

/**
 * Surveys Controller
 *
 * @property \Qobo\Survey\Model\Table\SurveysTable $Surveys
 *
 * @method \Qobo\Survey\Model\Entity\Survey[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SurveysController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $surveys = $this->paginate($this->Surveys);
        $categories = $this->Surveys->getSurveyCategories();

        $this->set(compact('surveys', 'categories'));
    }

    /**
     * View method
     *
     * @param string|null $id Survey id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $survey = $this->Surveys->get($id, [
            'contain' => [
                'SurveyQuestions' => [
                    'sort' => ['SurveyQuestions.order' => 'ASC'],
                    'SurveyAnswers' => [
                        'sort' => ['SurveyAnswers.order' => 'ASC'],
                    ],
                ]
            ]
        ]);

        $this->set('survey', $survey);
    }

    /**
     * Publish method
     *
     * @param string|null $id Survey id.
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function publish($id = null)
    {
        $survey = $this->Surveys->get($id);

        if ($this->request->is(['post', 'put', 'patch'])) {
            $data = $this->request->getData();

            $survey = $this->Surveys->patchEntity($survey, $data, ['validate' => false]);
            if ($this->Surveys->save($survey)) {
                $this->Flash->success(__('Survey was successfully saved.'));

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('Couldn\'t publish the survey'));
        }

        $this->set(compact('survey'));
    }

    /**
     * Publish method
     *
     * @param string|null $id Survey id.
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function preview($id = null)
    {
        $survey = null;

        $query = $this->Surveys->find();
        $query->where(['id' => $id]);

        $query->contain([
            'SurveyQuestions' => [
                'sort' => ['SurveyQuestions.order' => 'ASC'],
                'SurveyAnswers' => [
                    'sort' => ['SurveyAnswers.order' => 'ASC'],
                ],
            ]
        ]);

        $query->execute();

        if ($query->count()) {
            $survey = $query->first();
        }

        $saved = [];

        if ($this->request->is(['post', 'put', 'patch'])) {
            $this->SurveyResults = TableRegistry::get('Qobo/Survey.SurveyResults');
            $user = $this->Auth->user();
            $questions = $this->request->getData();

            foreach ($questions['SurveyResults'] as $k => $item) {
                if (!is_array($item['survey_answer_id'])) {
                    $entity = $this->SurveyResults->newEntity();
                    $entity->user_id = $user['id'];
                    $entity->survey_id = $id;
                    $entity->survey_question_id = $item['survey_question_id'];
                    $entity->survey_answer_id = $item['survey_answer_id'];
                    $entity->result = (!empty($item['result']) ? $item['result'] : '');

                    $result = $this->SurveyResults->save($entity);
                    if ($result) {
                        $saved[] = $result;
                    }
                } else {
                    foreach ($item['survey_answer_id'] as $key => $answer) {
                        $entity = $this->SurveyResults->newEntity();
                        $entity->user_id = $user['id'];
                        $entity->survey_id = $id;
                        $entity->survey_question_id = $item['survey_question_id'];
                        $entity->survey_answer_id = $answer; //item['survey_answer_id'];
                        $entity->result = (!empty($item['result']) ? $item['result'] : '');

                        $result = $this->SurveyResults->save($entity);
                        if ($result) {
                            $saved[] = $result;
                        }
                    }
                }
            }

            if (!empty($saved)) {
                $this->Flash->success(__('Saved questionnaire results'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->success(__('Some errors took place during result savings'));
            }
        }

        $this->set(compact('survey'));
    }

    /**
     * Publish method
     *
     * @param string|null $id Survey id.
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function duplicate($id = null)
    {
        $this->autoRender = false;

        if ($this->request->is(['post', 'put', 'patch'])) {
            $duplicated = $this->Surveys->duplicate($id);
            if ($duplicated) {
                // @NOTE: saving parent_id as Duplicatable unsets origin id
                $duplicated = $this->Surveys->patchEntity($duplicated, ['parent_id' => $id]);
                $duplicated = $this->Surveys->save($duplicated);

                $this->Flash->success(__('Survey was successfully duplicated'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Couldn\'t duplicate the survey data'));
        }
    }
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $survey = $this->Surveys->newEntity();
        $categories = $this->Surveys->getSurveyCategories();

        if ($this->request->is('post')) {
            $survey = $this->Surveys->patchEntity($survey, $this->request->getData());
            if ($this->Surveys->save($survey)) {
                $this->Flash->success(__('The survey has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The survey could not be saved. Please, try again.'));
        }
        $this->set(compact('survey', 'categories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Survey id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $categories = $this->Surveys->getSurveyCategories();
        $survey = $this->Surveys->get($id, [
            'contain' => []
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $survey = $this->Surveys->patchEntity($survey, $this->request->getData());
            if ($this->Surveys->save($survey)) {
                $this->Flash->success(__('The survey has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The survey could not be saved. Please, try again.'));
        }
        $this->set(compact('survey', 'categories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Survey id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $survey = $this->Surveys->get($id);
        if ($this->Surveys->delete($survey)) {
            $this->Flash->success(__('The survey has been deleted.'));
        } else {
            $this->Flash->error(__('The survey could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
