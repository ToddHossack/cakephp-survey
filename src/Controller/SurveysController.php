<?php
/**
 * Copyright (c) Qobo Ltd. (https://www.qobo.biz)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Qobo Ltd. (https://www.qobo.biz)
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace Qobo\Survey\Controller;

use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Qobo\Survey\Controller\AppController;
use Qobo\Survey\Event\EventName;

/**
 * Surveys Controller
 *
 * @property \Qobo\Survey\Model\Table\SurveysTable $Surveys
 * @property \Qobo\Survey\Model\Table\SurveyAnswersTable $SurveyAnswers
 * @property \Qobo\Survey\Model\Table\SurveyQuestionsTable $SurveyQuestions
 * @property \Qobo\Survey\Model\Table\SurveyResultsTable $SurveyResults
 *
 * @method \Qobo\Survey\Model\Entity\Survey[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SurveysController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void|null
     */
    public function index()
    {
        $surveys = $this->paginate($this->Surveys);
        $this->set(compact('surveys'));
    }

    /**
     * Before Filter callback
     *
     * Preloading extra vars for all methods
     *
     * @param \Cake\Event\Event $event broadcasted.
     * @return void
     */
    public function beforeFilter(Event $event): void
    {
        parent::beforeFilter($event);

        $categories = $this->Surveys->getSurveyCategories();
        $this->set(compact('categories'));
    }

    /**
     * View method
     *
     * @param string|null $id Survey id.
     * @return \Cake\Http\Response|void|null
     */
    public function view(?string $id)
    {
        /**
         * @var \Qobo\Survey\Model\Table\SurveyQuestionsTable $table
         */
        $table = TableRegistry::get('Qobo/Survey.SurveyQuestions');
        $this->SurveyQuestions = $table;

        /**
         * @var \Qobo\Survey\Model\Table\SurveyResultsTable $table
         */
        $table = TableRegistry::get('Qobo/Survey.SurveyResults');
        $this->SurveyResults = $table;

        $questionTypes = $this->SurveyQuestions->getQuestionTypes();
        $survey = $this->Surveys->getSurveyData($id, true);

        $event = new Event((string)EventName::VIEW_SURVEY_RESULTS(), $this, [
            'user' => $this->Auth->user(),
            'survey' => $survey,
            'data' => [],
        ]);

        $this->getEventManager()->dispatch($event);

        if (!empty($event->result)) {
            $submits = $event->result;
        } else {
            if (! empty($survey)) {
                $submits = $this->SurveyResults->getSubmits($survey->get('id'));
            }
        }

        $this->set(compact('survey', 'questionTypes', 'submits'));
    }

    /**
     * Publish method
     *
     * @param string $id Survey id.
     * @return \Cake\Http\Response|void|null Redirects on successful add, renders view otherwise.
     */
    public function publish(string $id)
    {
        $survey = $this->Surveys->getSurveyData($id);

        if (empty($survey)) {
            $this->Flash->error((string)__('Couldn\'t find a survey with given id'));

            return $this->redirect($this->referer());
        }

        if ($this->request->is(['post', 'put', 'patch'])) {
            $validated = $this->Surveys->prepublishValidate($id, $this->request);

            if (false === $validated['status']) {
                $this->Flash->error(implode("\r\n", $validated['errors']), ['escape' => false]);

                return $this->redirect($this->referer());
            }

            $data = $this->request->getData();
            $survey = $this->Surveys->patchEntity($survey, (array)$data, ['validate' => false]);

            if ($this->Surveys->save($survey)) {
                $this->Flash->success((string)__('Survey was successfully saved.'));

                $fullSurvey = $this->Surveys->getSurveyData($survey->id, true);

                $event = new Event((string)EventName::PUBLISH_SURVEY(), $this, [
                    'data' => [
                        'action' => 'add_survey',
                        'survey' => $fullSurvey,
                    ]
                ]);
                $this->getEventManager()->dispatch($event);

                return $this->redirect(['action' => 'view', $id]);
            }

            $this->Flash->error((string)__('Couldn\'t publish the survey'));
        }

        $this->set(compact('survey'));
    }

    /**
     * Publish method
     *
     * @param string $id Survey id.
     * @return \Cake\Http\Response|void|null Redirects on successful add, renders view otherwise.
     */
    public function preview(string $id)
    {
        $saved = $data = [];
        $survey = $this->Surveys->getSurveyData($id, true);
        dd($this->Surveys->getSurveyBySections($id));
        if ($this->request->is(['post', 'put', 'patch'])) {
            /**
             * @var \Qobo\Survey\Model\Table\SurveyResultsTable $table
             */
            $table = TableRegistry::getTableLocator()->get('Qobo/Survey.SurveyResults');
            $this->SurveyResults = $table;

            $user = $this->Auth->user();
            $requestData = $this->request->getData();
            if (empty($requestData['SurveyResults'])) {
                $this->Flash->error((string)__('Please submit your survey answers'));

                return $this->redirect(['controller' => 'Surveys', 'action' => 'view', $id]);
            }

            foreach ($requestData['SurveyResults'] as $k => $item) {
                $results = $this->SurveyResults->getResults($item, [
                    'user' => $user,
                    'survey' => $survey,
                    'data' => $requestData
                ]);

                $data = array_merge($data, $results);
            }
            foreach ($data as $k => $surveyResult) {
                $saved[] = $this->SurveyResults->saveData($surveyResult);
            }

            $failed = array_filter($saved, function ($item) {
                if (!$item['status']) {
                    return $item;
                }
            });

            if (empty($failed)) {
                $this->Flash->success((string)__('Saved questionnaire results'));

                return $this->redirect(['controller' => 'Surveys', 'action' => 'view', $id]);
            } else {
                $this->Flash->success((string)__('Some errors took place during result savings'));
            }
        }

        $this->set(compact('survey'));
    }

    /**
     * Publish method
     *
     * @param string|null $id Survey id.
     * @return \Cake\Http\Response|void|null Redirects on successful add, renders view otherwise.
     */
    public function duplicate(?string $id)
    {
        $this->autoRender = false;
        $survey = $this->Surveys->getSurveyData($id);

        if (empty($survey)) {
            $this->Flash->error((string)__('Couldn\'t duplicate the survey data'));

            return $this->redirect($this->referer());
        }

        if ($this->request->is(['post', 'put', 'patch'])) {
            /**
             * @var \Cake\Datasource\EntityInterface
             */
            $duplicated = $this->Surveys->duplicate($survey->get('id'));

            if (! empty($duplicated)) {
                // @NOTE: saving parent_id as Duplicatable unsets origin id
                $duplicated = $this->Surveys->patchEntity($duplicated, ['parent_id' => $survey->get('id')]);
                $duplicated = $this->Surveys->save($duplicated);
                if ($duplicated instanceof EntityInterface) {
                    // Fixing order from original survey if there were any order gaps.
                    $sorted = $this->Surveys->setSequentialOrder($duplicated);

                    $this->Flash->success((string)__('Survey was successfully duplicated'));

                    return $this->redirect(['action' => 'view', $duplicated->get('id')]);
                }
            }
            $this->Flash->error((string)__('Couldn\'t duplicate the survey data'));
        }
    }
    /**
     * Add method
     *
     * @return \Cake\Http\Response|void|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $survey = $this->Surveys->newEntity();

        if ($this->request->is('post')) {
            $survey = $this->Surveys->patchEntity($survey, (array)$this->request->getData());
            if ($this->Surveys->save($survey)) {
                $this->Flash->success((string)__('The survey has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error((string)__('The survey could not be saved. Please, try again.'));
        }
        $this->set(compact('survey'));
    }

    /**
     * Edit method
     *
     * @param string $id Survey id.
     * @return \Cake\Http\Response|void|null Redirects on successful edit, renders view otherwise.
     */
    public function edit(string $id)
    {
        $survey = $this->Surveys->getSurveyData($id);
        $redirect = ['controller' => 'Surveys', 'action' => 'view', $id];

        if (empty($survey)) {
            $this->Flash->error((string)__('Couldn\'t find Survey with given id'));

            return $this->redirect($this->referer());
        }

        if (!empty($survey->publish_date)) {
            $this->Flash->error((string)__('You cannot edit alredy published survey'));

            return $this->redirect($redirect);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $survey = $this->Surveys->patchEntity($survey, (array)$this->request->getData());
            if ($this->Surveys->save($survey)) {
                $this->Flash->success((string)__('The survey has been saved.'));

                return $this->redirect($redirect);
            }
            $this->Flash->error((string)__('The survey could not be saved. Please, try again.'));
        }
        $this->set(compact('survey'));
    }

    /**
     * Delete method
     *
     * @param string $id Survey id.
     * @return \Cake\Http\Response|void|null Redirects to index.
     */
    public function delete(string $id)
    {
        $this->request->allowMethod(['post', 'delete']);
        $survey = $this->Surveys->getSurveyData($id);

        if (empty($survey)) {
            $this->Flash->error((string)__('The survey could not be deleted. Please, try again.'));

            return $this->redirect(['action' => 'index']);
        }

        if ($this->Surveys->delete($survey)) {
            $this->Flash->success((string)__('The survey has been deleted.'));
        } else {
            $this->Flash->error((string)__('The survey could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Get Specific survey results based on submission id
     *
     * @param string $surveyId of the given survey
     * @param string $submitId of specific submission
     *
     * @return \Cake\Http\Response|void|null
     */
    public function viewSubmit(string $surveyId, string $submitId)
    {
        $surveyResults = [];
        $survey = null;

        /**
         * @var \Qobo\Survey\Model\Table\SurveyQuestionsTable $table
         */
        $table = TableRegistry::get('Qobo/Survey.SurveyQuestions');
        $this->SurveyQuestions = $table;

        $survey = $this->Surveys->getSurveyData($surveyId);

        if (! empty($survey)) {
            $query = $this->SurveyQuestions->find()
                ->where(['survey_id' => $survey->get('id')]);
            $query->enableHydration(true);
            $query->contain([
                    'SurveyAnswers' => ['SurveyResults' => function ($q) use ($submitId) {
                        return $q->where(['submit_id' => $submitId]);
                    }]
                ]);

            if ($query->count()) {
                $surveyResults = $query->all();
            }
        }

        $this->set(compact('survey', 'surveyResults'));
    }
}
