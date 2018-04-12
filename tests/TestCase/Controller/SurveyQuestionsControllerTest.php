<?php
namespace Qobo\Survey\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;
use Qobo\Survey\Controller\SurveysController;
use Qobo\Survey\Model\Table\SurveyQuestionsTable;
use Qobo\Survey\Model\Table\SurveysTable;

class SurveyQuestionsControllerTest extends IntegrationTestCase
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
        $this->SurveyQuestions = TableRegistry::get('SurveyQuestions', ['className' => SurveyQuestionsTable::class]);
    }

    public function testViewOk()
    {
        $surveyId = '00000000-0000-0000-0000-000000000001';
        $survey = $this->Surveys->getSurveyData($surveyId);

        $slug = $survey->slug;

        $query = $this->SurveyQuestions->find()
            ->where(['survey_id' => $survey->id]);

        $question = $query->first();

        $this->get('/surveys/survey/' . $survey->slug . '/questions/view/' . $question->id);
        $this->assertResponseOk();
    }

    public function testPreviewOk()
    {
        $surveyId = '00000000-0000-0000-0000-000000000001';
        $survey = $this->Surveys->getSurveyData($surveyId);

        $slug = $survey->slug;

        $query = $this->SurveyQuestions->find()
            ->where(['survey_id' => $survey->id]);

        $question = $query->first();
        $url = '/surveys/survey/' . $survey->slug . '/questions/preview/' . $question->id;

        $this->get($url);
        $this->assertResponseOk();

        $this->post($url);
        $this->assertResponseOk();
    }

    public function testAddOk()
    {
        $surveyId = '00000000-0000-0000-0000-000000000001';
        $survey = $this->Surveys->getSurveyData($surveyId);

        $slug = $survey->slug;
        $url = '/surveys/survey/' . $survey->slug . '/questions/add';

        $this->get($url);
        $this->assertResponseOk();
    }

    public function testEditOk()
    {
        $surveyId = '00000000-0000-0000-0000-000000000001';
        $survey = $this->Surveys->getSurveyData($surveyId);

        $slug = $survey->slug;

        $query = $this->SurveyQuestions->find()
            ->where(['survey_id' => $survey->id]);

        $question = $query->first();
        $url = '/surveys/survey/' . $survey->slug . '/questions/edit/' . $question->id;

        $this->get($url);
        $this->assertResponseOk();
    }

    public function testDeleteOk()
    {
        $surveyId = '00000000-0000-0000-0000-000000000001';
        $survey = $this->Surveys->getSurveyData($surveyId);

        $slug = $survey->slug;

        $query = $this->SurveyQuestions->find()
            ->where(['survey_id' => $survey->id]);

        $question = $query->first();
        $url = '/surveys/survey/' . $survey->slug . '/questions/delete/' . $question->id;

        $this->delete($url);
        $this->assertRedirect(['controller' => 'Surveys', 'action' => 'view', $survey->slug]);
    }

    /**
     * \Cake\Datasource\Exception\RecordNotFoundException
     */
    public function testDeleteFailed()
    {
        $surveyId = '00000000-0000-0000-0000-000000000001';
        $survey = $this->Surveys->getSurveyData($surveyId);

        $slug = $survey->slug;

        $query = $this->SurveyQuestions->find()
            ->where(['survey_id' => $survey->id]);

        $question = $query->first();
        $url = '/surveys/survey/' . $survey->slug . '/questions/delete/' . $question->id;

        $fakeUrl = $url . '-fake';
        $this->delete($fakeUrl);
        $this->assertResponseCode(404);
    }

    public function testAddPostOk()
    {
        $surveyId = '00000000-0000-0000-0000-000000000001';
        $survey = $this->Surveys->getSurveyData($surveyId);
        $slug = $survey->slug;

        $postData = [
            'survey_id' => $survey->id,
            'question' => 'Who are you?',
            'type' => 'checkbox',
            'order' => 1
        ];

        $this->post('/surveys/survey/' . $survey->slug . '/questions/add', $postData);
        $query = $this->SurveyQuestions->find()
            ->where(['question' => $postData['question']]);

        $question = $query->first();
        $this->assertRedirect(['controller' => 'SurveyQuestions', 'action' => 'view', $survey->slug, $question->id]);
        $this->assertEquals($question->question, $postData['question']);
        $this->assertEquals($question->type, $postData['type']);
    }

    public function testEditPostOk()
    {
        $surveyId = '00000000-0000-0000-0000-000000000001';
        $questionId = '00000000-0000-0000-0000-000000000001';
        $survey = $this->Surveys->getSurveyData($surveyId);
        $slug = $survey->slug;

        $editData = [
            'question' => 'Who are they?',
        ];

        $this->post('/surveys/survey/' . $survey->slug . '/questions/edit/' . $questionId, $editData);

        $query = $this->SurveyQuestions->find()
            ->where(['id' => $questionId]);

        $editedQuestion = $query->first();

        $this->assertRedirect(['controller' => 'SurveyQuestions', 'action' => 'view', $survey->slug, $editedQuestion->id]);
        $this->assertEquals($editedQuestion->question, $editData['question']);
        $this->assertEquals($editedQuestion->id, $questionId);
    }
}
