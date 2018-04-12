<?php
namespace Qobo\Survey\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;
use Qobo\Survey\Controller\SurveysController;
use Qobo\Survey\Model\Table\SurveysTable;
use Qobo\Survey\Model\Table\SurveyResultsTable;

class SurveysControllerTest extends IntegrationTestCase
{

    public $fixtures = [
        'plugin.qobo/survey.survey_results',
        'plugin.qobo/survey.survey_questions',
        'plugin.qobo/survey.survey_answers',
        'plugin.qobo/survey.surveys',
        'plugin.qobo/survey.users',
    ];

    public function setUp()
    {
        parent::setUp();

        $userId = '00000000-0000-0000-0000-000000000001';
        $this->session([
            'Auth' => [
                'User' => TableRegistry::get('Users')->get($userId)->toArray()
            ]
        ]);

        $this->Surveys = TableRegistry::get('Surveys', ['className' => SurveysTable::class]);
        $this->SurveyResults = TableRegistry::get('SurveyResults', ['className' => SurveyResultsTable::class]);
    }

    public function tearDown()
    {
        unset($this->Surveys);
        parent::tearDown();
    }

    public function testIndex()
    {
        $this->get('/surveys/surveys');
        $this->assertResponseOk();
    }

    public function testAdd()
    {
        $this->get('/surveys/surveys/add');
        $this->assertResponseOk();
    }

    public function testEdit()
    {
        $surveyId = '00000000-0000-0000-0000-000000000001';
        $this->get('/surveys/surveys/edit/' . $surveyId);
        $this->assertResponseOk();
    }

    public function testViewOk()
    {
        $surveyId = '00000000-0000-0000-0000-000000000001';
        $this->get('/surveys/surveys/view/' . $surveyId);
        $this->assertResponseOk();
    }

    public function testPublishOk()
    {
        $surveyId = '00000000-0000-0000-0000-000000000001';
        $this->get('/surveys/surveys/publish/' . $surveyId);
        $this->assertResponseOk();
    }

    public function testDuplicateOk()
    {
        $surveyId = '00000000-0000-0000-0000-000000000001';
        $this->get('/surveys/surveys/duplicate/' . $surveyId);
        $this->assertResponseOk();
    }

    public function testDeleteRedirectOk()
    {
        $surveyId = '00000000-0000-0000-0000-000000000001';
        $this->delete('/surveys/surveys/delete/' . $surveyId);
        $this->assertRedirect(['controller' => 'Surveys', 'action' => 'index']);
    }

    public function testPreviewGet()
    {
        $surveyId = '00000000-0000-0000-0000-000000000001';
        $this->get('/surveys/surveys/preview/' . $surveyId);

        $this->assertResponseOk();
    }

    public function testAddPostOk()
    {
        $data = [
            'name' => 'Test',
            'active' => true,
            'slug' => 'test_foobar',
            'description' => 'Test Survey',
            'category' => 'default',
        ];

        $this->post('/surveys/surveys/add', $data);
        $this->assertRedirect(['controller' => 'Surveys', 'action' => 'index']);

        $query = $this->Surveys->find()
            ->where(['slug' => 'test_foobar']);
        $survey = $query->first();
        $this->assertEquals($survey->slug, $data['slug']);
        $this->assertEquals($survey->name, $data['name']);
    }

    public function testEditPostOk()
    {
        $query = $this->Surveys->find()
            ->limit(1);

        $survey = $query->first();

        $edit = [
            'name' => 'Modified Name',
        ];

        $this->post('/surveys/surveys/edit/' . $survey->id, $edit);
        $this->assertRedirect(['controller' => 'Surveys', 'action' => 'view', $survey->id]);

        $query = $this->Surveys->find()
            ->where(['id' => $survey->id]);

        $newSurvey = $query->first();
        $this->assertEquals($newSurvey->name, $edit['name']);
    }

    public function testDuplicatePostOk()
    {
        $query = $this->Surveys->find()
            ->limit(1);
        $survey = $query->first();

        $this->post('/surveys/surveys/duplicate/' . $survey->id);
        $this->assertRedirect(['controller' => 'Surveys', 'action' => 'index']);

        $query = $this->Surveys->find()
            ->where(['parent_id' => $survey->id]);

        $duplicated = $query->first();
        $this->assertEquals($survey->id, $duplicated->parent_id);
    }

    public function testPublishPostOk()
    {
        $query = $this->Surveys->find()
            ->limit(1);
        $survey = $query->first();
        $data = [
            'publish_date' => '2018-04-08 09:00:00',
        ];

        $this->post('/surveys/surveys/publish/' . $survey->id, $data);
        $this->assertRedirect(['controller' => 'Surveys', 'action' => 'view', $survey->id]);

        $query = $this->Surveys->find()
            ->where(['id' => $survey->id]);

        $published = $query->first();

        $this->assertNotEmpty($published->publish_date);
        $this->assertEquals($published->publish_date->i18nFormat('yyyy-MM-dd HH:mm:ss'), $data['publish_date']);
    }

    public function testPreviewPost()
    {
        $query = $this->Surveys->find()
            ->limit(1);
        $survey = $query->first();

        $postData = [];

        $this->post('/surveys/surveys/preview/' . $survey->id, $postData);
        $this->assertRedirect(['controller' => 'Surveys', 'action' => 'view', $survey->id]);

        // Each survey/question/answer
        // has a record with id '00000000-0000-0000-0000-000000000001'
        // in the fixtures, so we use it for simplicity.
        $genericId = '00000000-0000-0000-0000-000000000001';

        $postData = [
            'SurveyResults' => [
                [
                    'survey_id' => $survey->id,
                    'survey_question_id' => $genericId,
                    'survey_answer_id' => $genericId,
                    'result' => 'foobar',
                ]
            ]
        ];

        $this->post('/surveys/surveys/preview/' . $survey->id, $postData);
        $this->assertRedirect(['controller' => 'Surveys', 'action' => 'view', $survey->id]);

        $query = $this->SurveyResults->find()
            ->where(['result' => 'foobar']);

        $resultData = $query->first();
        $this->assertEquals($resultData->survey_id, $survey->id);
        $this->assertEquals($resultData->survey_question_id, $genericId);
        $this->assertEquals($resultData->result, 'foobar');
    }
}
