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

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Qobo\Survey\Event\EventName;

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
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        $categories = $this->Surveys->getSurveyCategories();
        $this->set(compact('categories'));
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
        $this->SurveyQuestions = TableRegistry::get('Qobo/Survey.SurveyQuestions');

        $questionTypes = $this->SurveyQuestions->getQuestionTypes();
        $survey = $this->Surveys->getSurveyData($id, true);

        $this->set(compact('survey', 'questionTypes'));
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
        $survey = $this->Surveys->getSurveyData($id);

        if ($this->request->is(['post', 'put', 'patch'])) {
            $data = $this->request->getData();

            $survey = $this->Surveys->patchEntity($survey, $data, ['validate' => false]);
            if ($this->Surveys->save($survey)) {
                $this->Flash->success(__('Survey was successfully saved.'));

                $fullSurvey = $this->Surveys->getSurveyData($survey->id, true);

                $event = new Event((string)EventName::PUBLISH_SURVEY(), $this, [
                    'data' => [
                        'action' => 'add_survey',
                        'survey' => $fullSurvey,
                    ]
                ]);
                $this->eventManager()->dispatch($event);

                return $this->redirect(['action' => 'view', $id]);
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
        $saved = $data = [];
        $survey = $this->Surveys->getSurveyData($id, true);

        if ($this->request->is(['post', 'put', 'patch'])) {
            $this->SurveyResults = TableRegistry::get('Qobo/Survey.SurveyResults');
            $user = $this->Auth->user();

            if (empty($this->request->data['SurveyResults'])) {
                $this->Flash->error(__('Please submit your survey answers'));

                return $this->redirect(['controller' => 'Surveys', 'action' => 'view', $id]);
            }

            foreach ($this->request->data['SurveyResults'] as $k => $item) {
                $results = $this->SurveyResults->getResults($item, [
                    'user' => $user,
                    'survey' => $survey,
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
                $this->Flash->success(__('Saved questionnaire results'));

                return $this->redirect(['controller' => 'Surveys', 'action' => 'view', $id]);
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
        $survey = $this->Surveys->getSurveyData($id);

        if ($this->request->is(['post', 'put', 'patch'])) {
            $duplicated = $this->Surveys->duplicate($survey->id);

            if ($duplicated) {
                // @NOTE: saving parent_id as Duplicatable unsets origin id
                $duplicated = $this->Surveys->patchEntity($duplicated, ['parent_id' => $survey->id]);
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

        if ($this->request->is('post')) {
            $survey = $this->Surveys->patchEntity($survey, $this->request->getData());
            if ($this->Surveys->save($survey)) {
                $this->Flash->success(__('The survey has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The survey could not be saved. Please, try again.'));
        }
        $this->set(compact('survey'));
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
        $survey = $this->Surveys->getSurveyData($id);
        $redirect = ['controller' => 'Surveys', 'action' => 'view', $survey->id];

        if (!empty($survey->publish_date)) {
            $this->Flash->error(__('You cannot edit alredy published survey'));

            return $this->redirect($redirect);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $survey = $this->Surveys->patchEntity($survey, $this->request->getData());
            if ($this->Surveys->save($survey)) {
                $this->Flash->success(__('The survey has been saved.'));

                return $this->redirect($redirect);
            }
            $this->Flash->error(__('The survey could not be saved. Please, try again.'));
        }
        $this->set(compact('survey'));
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
        $survey = $this->Surveys->getSurveyData($id);
        if ($this->Surveys->delete($survey)) {
            $this->Flash->success(__('The survey has been deleted.'));
        } else {
            $this->Flash->error(__('The survey could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
