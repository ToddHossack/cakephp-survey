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

        if ($this->request->is('post')) {
            $surveySection = $this->SurveySections->patchEntity($surveySection, $this->request->getData());
            if ($this->SurveySections->save($surveySection)) {
                $this->Flash->success(__('The survey section has been saved.'));

                return $this->redirect(['controller' => 'SurveySections', 'action' => 'view', $surveyId]);
            }
            $this->Flash->error(__('The survey section could not be saved. Please, try again.'));
        }
        $surveys = $this->SurveySections->Surveys->find('list', ['limit' => 200]);
        $this->set(compact('surveySection', 'survey'));
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
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            // dd($this->request->getData());
            $surveySection = $this->SurveySections->patchEntity($surveySection, $this->request->getData());
            if ($this->SurveySections->save($surveySection)) {
                $this->Flash->success(__('The survey section has been saved.'));

                return $this->redirect(['controller' => 'Surveys', 'action' => 'view', $surveyId]);
            }
            $this->Flash->error(__('The survey section could not be saved. Please, try again.'));
        }
        $surveys = $this->SurveySections->Surveys->find('list', ['limit' => 200]);
        $this->set(compact('surveySection', 'survey'));
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
