<?php
namespace Qobo\Survey\Test\TestCase\Controller;

use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;
use Qobo\Survey\Controller\SurveysController;
use Qobo\Survey\Model\Table\SurveyEntriesTable;
use Qobo\Survey\Model\Table\SurveyResultsTable;
use Qobo\Survey\Model\Table\SurveysTable;
use Webmozart\Assert\Assert;

class SurveysControllerTest extends IntegrationTestCase
{

    public $fixtures = [
        'plugin.qobo/survey.survey_results',
        'plugin.qobo/survey.survey_questions',
        'plugin.qobo/survey.survey_answers',
        'plugin.qobo/survey.survey_entries',
        'plugin.qobo/survey.survey_sections',
        'plugin.qobo/survey.surveys',
        'plugin.qobo/survey.users',
    ];

    /**
     * @var \Qobo\Survey\Model\Table\SurveysTable
     */
    public $Surveys;

    /**
     * @var \Qobo\Survey\Model\Table\SurveyResultsTable
     */
    public $SurveyResults;

    /**
     * @var \Qobo\Survey\Model\Table\SurveyEntriesTable
     */
    public $SurveyEntries;

    public function setUp()
    {
        parent::setUp();

        $userId = '00000000-0000-0000-0000-000000000001';
        $this->session([
            'Auth' => [
                'User' => TableRegistry::get('Users')->get($userId)->toArray()
            ]
        ]);

        /**
         * @var \Qobo\Survey\Model\Table\SurveysTable $table
         */
        $table = TableRegistry::get('Qobo/Survey.Surveys', ['className' => SurveysTable::class]);
        $this->Surveys = $table;

        /**
         * @var \Qobo\Survey\Model\Table\SurveyResultsTable $table
         */
        $table = TableRegistry::get('Qobo/Survey.SurveyResults', ['className' => SurveyResultsTable::class]);
        $this->SurveyResults = $table;

        /**
         * @var \Qobo\Survey\Model\Table\SurveyEntriesTable $table
         */
        $table = TableRegistry::get('Qobo/Survey.SurveyEntries', ['className' => SurveyEntriesTable::class]);
        $this->SurveyEntries = $table;
    }

    public function tearDown()
    {
        unset($this->Surveys);
        parent::tearDown();
    }

    public function testIndex(): void
    {
        $this->get('/surveys/surveys');
        $this->assertResponseOk();
    }

    public function testAdd(): void
    {
        $this->get('/surveys/surveys/add');
        $this->assertResponseOk();
    }

    public function testEdit(): void
    {
        $surveyId = '00000000-0000-0000-0000-000000000001';
        $this->get('/surveys/surveys/edit/' . $surveyId);
        $this->assertResponseOk();
    }

    public function testViewOk(): void
    {
        $surveyId = '00000000-0000-0000-0000-000000000001';
        $this->get('/surveys/surveys/view/' . $surveyId);
        $this->assertResponseOk();
    }

    public function testPublishOk(): void
    {
        $surveyId = '00000000-0000-0000-0000-000000000001';
        $this->get('/surveys/surveys/publish/' . $surveyId);
        $this->assertResponseOk();
    }

    public function testDuplicateOk(): void
    {
        $surveyId = '00000000-0000-0000-0000-000000000001';
        $this->get('/surveys/surveys/duplicate/' . $surveyId);
        $this->assertResponseOk();
    }

    public function testDeleteRedirectOk(): void
    {
        $surveyId = '00000000-0000-0000-0000-000000000001';
        $this->delete('/surveys/surveys/delete/' . $surveyId);
        $this->assertRedirect(['controller' => 'Surveys', 'action' => 'index']);
    }

    public function testPreviewGet(): void
    {
        $surveyId = '00000000-0000-0000-0000-000000000001';
        $this->get('/surveys/surveys/preview/' . $surveyId);
        $this->assertResponseOk();
    }

    public function testAddPostOk(): void
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
        /**
         * @var \Qobo\Survey\Model\Entity\Survey $survey
         */
        $survey = $query->first();
        $this->assertEquals($survey->slug, $data['slug']);
        $this->assertEquals($survey->name, $data['name']);
    }

    public function testAddPostError(): void
    {
        $this->enableRetainFlashMessages();
        $data = [
            'active' => true,
            'slug' => 'test_foobar',
        ];

        $this->post('/surveys/surveys/add', $data);
        $this->assertSession('The survey could not be saved. Please, try again.', 'Flash.flash.0.message');
    }

    public function testEditPostOk(): void
    {
        $query = $this->Surveys->find()
            ->limit(1);

        /**
         * @var \Qobo\Survey\Model\Entity\Survey $survey
         */
        $survey = $query->first();
        $edit = [
            'name' => 'Modified Name',
        ];

        $this->post('/surveys/surveys/edit/' . $survey->id, $edit);
        $this->assertRedirect(['controller' => 'Surveys', 'action' => 'view', $survey->id]);

        $query = $this->Surveys->find()
            ->where(['id' => $survey->id]);

        /**
         * @var \Qobo\Survey\Model\Entity\Survey $newSurvey
         */
        $newSurvey = $query->first();
        $this->assertEquals($newSurvey->name, $edit['name']);
    }

    public function testEditPostError(): void
    {
        // you cannot publish already published survey
        $id = '00000000-0000-0000-0000-000000000002';
        $survey = $this->Surveys->get($id);

        $edit = [
            'name' => 'Modified Name',
        ];

        $this->post('/surveys/surveys/edit/' . $survey->get('id'), $edit);
        $this->assertSession('You cannot edit alredy published survey', 'Flash.flash.0.message');
    }

    public function testDuplicatePostOk(): void
    {
        $query = $this->Surveys->find()
            ->limit(1);
        /**
         * @var \Qobo\Survey\Model\Entity\Survey $survey
         */
        $survey = $query->first();

        $this->post('/surveys/surveys/duplicate/' . $survey->id);

        $query = $this->Surveys->find()
            ->where(['parent_id' => $survey->id]);

        /**
         * @var \Qobo\Survey\Model\Entity\Survey $duplicated
         */
        $duplicated = $query->first();
        $this->assertRedirect(['controller' => 'Surveys', 'action' => 'view', $duplicated->id]);
        $this->assertEquals($survey->id, $duplicated->parent_id);
    }

    public function testPublishPostOk(): void
    {
        $id = '00000000-0000-0000-0000-000000000003';
        $query = $this->Surveys->find()
            ->where(['id' => $id]);
        /**
         * @var \Qobo\Survey\Model\Entity\Survey $survey
         */
        $survey = $query->first();

        $data = [
            'Surveys' => [
                'publish_date' => '2018-04-08 09:00:00',
                'expiry_date' => '2019-04-18 09:00:00',
            ]
        ];

        $this->post('/surveys/surveys/publish/' . $survey->id, $data);
        $this->assertRedirect(['controller' => 'Surveys', 'action' => 'view', $survey->id]);

        $query = $this->Surveys->find()
            ->where(['id' => $survey->id]);

        /**
         * @var \Qobo\Survey\Model\Entity\Survey $published
         */
        $published = $query->first();

        $this->assertNotEmpty($published->publish_date);
        $this->assertEquals($published->publish_date->i18nFormat('yyyy-MM-dd HH:mm:ss'), $data['Surveys']['publish_date']);
    }

    public function testPublishPostError(): void
    {
        $id = '00000000-0000-0000-0000-000000000003';
        $query = $this->Surveys->find()
            ->where(['id' => $id]);
        /**
         * @var \Qobo\Survey\Model\Entity\Survey $survey
         */
        $survey = $query->first();

        $data = [
            'Surveys' => [
                'publish_date' => '2018-04-08 09:00:00',
                'expiry_date' => '2017-04-18 09:00:00',
            ]
        ];

        $this->post('/surveys/surveys/publish/' . $survey->get('id'), $data);
        $this->assertSession('Expiry date should be bigger than publish date', 'Flash.flash.0.message');
    }

    // @TODO: Given test doesn't/won't reflect current preview behaviour
    public function testPreviewPost(): void
    {
        $this->markTestSkipped((string)__('This test needs refactoring as part of separate PR'));
        $query = $this->Surveys->find()
            ->limit(1);
        /**
         * @var \Qobo\Survey\Model\Entity\Survey $survey
         */
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

        /**
         * @var \Qobo\Survey\Model\Entity\SurveyResult $resultData
         */
        $resultData = $query->first();
        $this->assertEquals($resultData->survey_id, $survey->id);
        $this->assertEquals($resultData->survey_question_id, $genericId);
        $this->assertEquals($resultData->result, 'foobar');
    }

    /**
     * Testing Surveys submit method with `POST` action
     *
     * @return void
     */
    public function testSubmitOk() : void
    {
        $this->enableRetainFlashMessages();

        $surveyId = '00000000-0000-0000-0000-000000000004';
        $survey = $this->Surveys->get($surveyId);

        $data = [
            'SurveyEntries' => [
                'survey_id' => $survey->get('id'),
                'submit_date' => Time::now(),
                'resource' => 'Users'
            ],
            'SurveyResults' => [
                [
                    'survey_question_id' => '00000000-0000-0000-0000-000000000007',
                    'survey_answer_id' => '00000000-0000-0000-0000-000000000010',
                ],
                [
                    'survey_question_id' => '00000000-0000-0000-0000-000000000006',
                    'survey_answer_id' => null,
                ],
            ]
        ];

        $this->post('/surveys/surveys/submit', $data);
        $this->assertSession('Successfully submitted survey', 'Flash.flash.0.message');

        $saved = $this->SurveyResults->find()
            ->where([
                'survey_id' => $surveyId,
                'survey_question_id' => '00000000-0000-0000-0000-000000000007'
            ])->first();

        Assert::isInstanceOf($saved, \Qobo\Survey\Model\Entity\SurveyResult::class);

        $this->assertEquals('00000000-0000-0000-0000-000000000010', $saved->get('survey_answer_id'));
        $this->assertEquals('10', $saved->get('score'));
    }

    public function testSubmitMultiplAnswerOk() : void
    {
        $this->enableRetainFlashMessages();

        $surveyId = '00000000-0000-0000-0000-000000000004';
        $survey = $this->Surveys->get($surveyId);

        $data = [
            'SurveyEntries' => [
                'survey_id' => $survey->get('id'),
                'submit_date' => Time::now(),
                'resource' => 'Users'
            ],
            'SurveyResults' => [
                [
                    'survey_question_id' => '00000000-0000-0000-0000-000000000007',
                    'survey_answer_id' =>
                    [
                        '00000000-0000-0000-0000-000000000010',
                        '00000000-0000-0000-0000-000000000009',
                    ]
                ],
            ]
        ];

        $this->post('/surveys/surveys/submit', $data);
        $this->assertSession('Successfully submitted survey', 'Flash.flash.0.message');

        $saved = $this->SurveyResults->find()
            ->where([
                'survey_id' => $surveyId,
                'survey_question_id' => '00000000-0000-0000-0000-000000000007'
            ]);

        $this->assertEquals(2, $saved->count());
    }
}
