<?php
namespace Qobo\Survey\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;
use Qobo\Survey\Controller\SurveySectionsController;
use Qobo\Survey\Model\Table\SurveySectionsTable;
use Qobo\Survey\Model\Table\SurveysTable;

/**
 * Qobo\Survey\Controller\SurveySectionsController Test Case
 */
class SurveySectionsControllerTest extends IntegrationTestCase
{
    /**
     * @var \Qobo\Survey\Model\Table\SurveysTable
     */
    public $Surveys;

    /**
     * @var \Qobo\Survey\Model\Table\SurveySectionsTable $SurveySections
     */
    public $SurveySections;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
         'plugin.qobo/survey.survey_results',
         'plugin.qobo/survey.survey_questions',
         'plugin.qobo/survey.survey_answers',
         'plugin.qobo/survey.survey_sections',
         'plugin.qobo/survey.surveys',
         'plugin.qobo/survey.users',
     ];

    /**
     * Setup method callback
     * @return void
     */
    public function setUp(): void
    {
         parent::setUp();

         $userId = '00000000-0000-0000-0000-000000000001';
         $this->session([
             'Auth' => [
                 'User' => TableRegistry::getTableLocator()->get('Users')->get($userId)->toArray(),
             ],
         ]);

         /**
          * @var \Qobo\Survey\Model\Table\SurveysTable $table
          */
         $table = TableRegistry::getTableLocator()->get('Qobo/Survey.Surveys', ['className' => SurveysTable::class]);
         $this->Surveys = $table;

         /** @var \Qobo\Survey\Model\Table\SurveySectionsTable $table */
         $table = TableRegistry::getTableLocator()->get('Qobo/Survey.SurveySections', ['className' => SurveySectionsTable::class]);
         $this->SurveySections = $table;
    }

    /**
     * Tear down callback
     */
    public function tearDown(): void
    {
         unset($this->Surveys);
         unset($this->SurveySections);
         parent::tearDown();
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd(): void
    {
        $surveyId = '00000000-0000-0000-0000-000000000001';
        /** @var \Cake\Datasource\EntityInterface $survey */
        $survey = $this->Surveys->getSurveyData($surveyId);

        $data = [
            'survey_id' => $surveyId,
            'name' => 'Foobar',
            'active' => 1,
            'order' => 123,
        ];

        $this->post('/surveys/survey-sections/add/' . $survey->get('slug'), $data);
        $this->assertRedirect([
            'plugin' => 'Qobo/Survey',
            'controller' => 'Surveys',
            'action' => 'view',
            $survey->get('slug'),
        ]);

        $entity = $this->SurveySections->find()
            ->where($data)
            ->first();

        $this->assertNotEmpty($entity);
        $this->assertInstanceOf(\Cake\Datasource\EntityInterface::class, $entity);
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit(): void
    {
        $surveyId = '00000000-0000-0000-0000-000000000001';
        /** @var \Cake\Datasource\EntityInterface $survey */
        $survey = $this->Surveys->getSurveyData($surveyId);

        $entity = $this->SurveySections->get($surveyId);
        $data = [
            'name' => 'Default - edited',
            'survey_section_id' => $entity->get('id'),
        ];

        $url = '/surveys/survey-sections/edit/' . $survey->get('slug') . '/' . $entity->get('id');

        $this->get($url);
        $this->assertResponseOk();

        $this->post($url, $data);
        $this->assertRedirect([
            'plugin' => 'Qobo/Survey',
            'controller' => 'Surveys',
            'action' => 'view',
            $survey->get('slug'),
        ]);
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete(): void
    {
        $surveyId = '00000000-0000-0000-0000-000000000001';
        /** @var \Cake\Datasource\EntityInterface $survey */
        $survey = $this->Surveys->getSurveyData($surveyId);

        $section = $this->SurveySections->get($surveyId);

        $url = '/surveys/survey-sections/delete/' . $survey->get('slug') . '/' . $section->get('id');

        $this->post($url);
        $this->assertRedirect([
            'plugin' => 'Qobo/Survey',
            'controller' => 'Surveys',
            'action' => 'view',
            $survey->get('slug'),
        ]);
    }
}
