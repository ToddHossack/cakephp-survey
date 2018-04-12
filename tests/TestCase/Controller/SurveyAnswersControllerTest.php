<?php
namespace Qobo\Survey\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;
use Qobo\Survey\Controller\SurveysController;
use Qobo\Survey\Model\Table\SurveyAnswersTable;
use Qobo\Survey\Model\Table\SurveyQuestionsTable;
use Qobo\Survey\Model\Table\SurveysTable;

class SurveyAnswersControllerTest extends IntegrationTestCase
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
        $this->SurveyAnswers = TableRegistry::get('SurveyAnswers', ['className' => SurveyAnswersTable::class]);
    }

    public function testViewOk()
    {
        $surveyId = '00000000-0000-0000-0000-000000000001';
        $survey = $this->Surveys->getSurveyData($surveyId);

        $query = $this->SurveyQuestions->find()
            ->where(['survey_id' => $survey->id]);
        $question = $query->first();

        $query = $this->SurveyAnswers->find()
            ->where(['survey_question_id' => $question->id]);

        $answer = $query->first();

        $url = '/surveys/survey/' . $survey->slug . '/answers/view/' . $question->id . '/' . $answer->id;
        $this->get($url);
        $this->assertResponseOk();
    }

    public function testAddGetOk()
    {
        $surveyId = '00000000-0000-0000-0000-000000000001';
        $survey = $this->Surveys->getSurveyData($surveyId);

        $query = $this->SurveyQuestions->find()
            ->where(['survey_id' => $survey->id]);
        $question = $query->first();

        $url = '/surveys/survey/' . $survey->slug . '/answers/add/' . $question->id;
        $this->get($url);
        $this->assertResponseOk();
    }

    public function testEditGetOk()
    {
        $surveyId = '00000000-0000-0000-0000-000000000001';
        $survey = $this->Surveys->getSurveyData($surveyId);

        $query = $this->SurveyQuestions->find()
            ->where(['survey_id' => $survey->id]);
        $question = $query->first();

        $query = $this->SurveyAnswers->find()
            ->where(['survey_question_id' => $question->id]);

        $answer = $query->first();

        $url = '/surveys/survey/' . $survey->slug . '/answers/edit/' . $question->id . '/' . $answer->id;
        $this->get($url);
        $this->assertResponseOk();
    }

    public function testDeleteOk()
    {
        $surveyId = '00000000-0000-0000-0000-000000000001';
        $survey = $this->Surveys->getSurveyData($surveyId);

        $query = $this->SurveyQuestions->find()
            ->where(['survey_id' => $survey->id]);
        $question = $query->first();

        $query = $this->SurveyAnswers->find()
            ->where(['survey_question_id' => $question->id]);

        $answer = $query->first();

        $url = '/surveys/survey/' . $survey->slug . '/answers/delete/' . $question->id . '/' . $answer->id;
        $this->delete($url);
        $redirect = ['controller' => 'SurveyQuestions', 'action' => 'view', $survey->slug, $question->id];
        $this->assertRedirect($redirect);
    }
}
