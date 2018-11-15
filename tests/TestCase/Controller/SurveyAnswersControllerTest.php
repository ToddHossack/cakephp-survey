<?php
namespace Qobo\Survey\Test\TestCase\Controller;

use Cake\Datasource\EntityInterface;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;
use Qobo\Survey\Controller\SurveysController;
use Qobo\Survey\Model\Table\SurveyAnswersTable;
use Qobo\Survey\Model\Table\SurveyQuestionsTable;
use Qobo\Survey\Model\Table\SurveysTable;

/**
 * @property \Qobo\Survey\Model\Table\SurveysTable $Surveys
 * @property \Qobo\Survey\Model\Table\SurveyQuestionsTable $SurveyQuestions
 * @property \Qobo\Survey\Model\Table\SurveyAnswersTable $SurveyAnswers
 */
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

        /**
         * @var \Qobo\Survey\Model\Table\SurveysTable $table
         */
        $table = TableRegistry::get('Surveys', ['className' => SurveysTable::class]);
        $this->Surveys = $table;

        /**
         * @var \Qobo\Survey\Model\Table\SurveyQuestionsTable $table
         */
        $table = TableRegistry::get('SurveyQuestions', ['className' => SurveyQuestionsTable::class]);
        $this->SurveyQuestions = $table;

        /**
         * @var \Qobo\Survey\Model\Table\SurveyAnswersTable $table
         */
        $table = TableRegistry::get('SurveyAnswers', ['className' => SurveyAnswersTable::class]);
        $this->SurveyAnswers = $table;
    }

    public function testViewOk(): void
    {
        $surveyId = '00000000-0000-0000-0000-000000000001';
        /**
         * @var \Cake\Datasource\EntityInterface
         */
        $survey = $this->Surveys->getSurveyData($surveyId);

        $query = $this->SurveyQuestions->find()
            ->where(['survey_id' => $survey->get('id')]);
        /**
         * @var \Cake\Datasource\EntityInterface
         */
        $question = $query->first();

        $query = $this->SurveyAnswers->find()
            ->where(['survey_question_id' => $question->get('id')]);

        /**
         * @var \Cake\Datasource\EntityInterface
         */
        $answer = $query->first();

        $url = '/surveys/survey/' . $survey->get('slug') . '/answers/view/' . $question->get('id') . '/' . $answer->get('id');
        $this->get($url);
        $this->assertResponseOk();
    }

    public function testAddGetOk(): void
    {
        $surveyId = '00000000-0000-0000-0000-000000000001';
        /**
         * @var \Cake\Datasource\EntityInterface
         */
        $survey = $this->Surveys->getSurveyData($surveyId);

        $query = $this->SurveyQuestions->find()
            ->where(['survey_id' => $survey->get('id')]);

        /**
         * @var \Cake\Datasource\EntityInterface
         */
        $question = $query->first();

        $url = '/surveys/survey/' . $survey->get('slug') . '/answers/add/' . $question->get('id');
        $this->get($url);
        $this->assertResponseOk();
    }

    public function testEditGetOk(): void
    {
        $surveyId = '00000000-0000-0000-0000-000000000001';
        /**
         * @var \Cake\Datasource\EntityInterface
         */
        $survey = $this->Surveys->getSurveyData($surveyId);

        $query = $this->SurveyQuestions->find()
            ->where(['survey_id' => $survey->get('id')]);

        /**
         * @var \Cake\Datasource\EntityInterface
         */
        $question = $query->first();

        $query = $this->SurveyAnswers->find()
            ->where(['survey_question_id' => $question->get('id')]);

        /**
         * @var \Cake\Datasource\EntityInterface
         */
        $answer = $query->first();

        $url = '/surveys/survey/' . $survey->get('slug') . '/answers/edit/' . $question->get('id') . '/' . $answer->get('id');
        $this->get($url);
        $this->assertResponseOk();
    }

    public function testDeleteOk(): void
    {
        $surveyId = '00000000-0000-0000-0000-000000000001';
        /**
         * @var \Cake\Datasource\EntityInterface
         */
        $survey = $this->Surveys->getSurveyData($surveyId);

        $query = $this->SurveyQuestions->find()
            ->where(['survey_id' => $survey->get('id')]);
        /**
         * @var \Cake\Datasource\EntityInterface
         */
        $question = $query->first();

        $query = $this->SurveyAnswers->find()
            ->where(['survey_question_id' => $question->get('id')]);
        /**
         * @var \Cake\Datasource\EntityInterface
         */
        $answer = $query->first();

        $url = '/surveys/survey/' . $survey->get('slug') . '/answers/delete/' . $question->get('id') . '/' . $answer->get('id');
        $this->delete($url);
        $redirect = ['controller' => 'SurveyQuestions', 'action' => 'view', $survey->get('slug'), $question->get('id')];
        $this->assertRedirect($redirect);
    }

    public function testAddPostOk(): void
    {
        $surveyId = '00000000-0000-0000-0000-000000000001';
        /**
         * @var \Cake\Datasource\EntityInterface
         */
        $survey = $this->Surveys->getSurveyData($surveyId);

        $query = $this->SurveyQuestions->find()
            ->where(['survey_id' => $survey->get('id')]);
        /**
         * @var \Cake\Datasource\EntityInterface
         */
        $question = $query->first();

        $postData = [
            'answer' => 'Whaat',
            'survey_question_id' => $question->get('id'),
            'score' => 999,
            'order' => 5,
        ];

        $this->post(
            '/surveys/survey/' . $survey->get('slug') . '/answers/add/' . $question->get('id'),
            $postData
        );

        $query = $this->SurveyAnswers->find()
            ->where(['score' => $postData['score']]);

        /**
         * @var \Cake\Datasource\EntityInterface
         */
        $saved = $query->first();

        $this->assertRedirect(['controller' => 'SurveyQuestions', 'action' => 'view', $survey->get('slug'), $question->get('id')]);
        $this->assertEquals($saved->get('order'), $postData['order']);
        $this->assertEquals($saved->get('answer'), $postData['answer']);
    }

    public function testEditPostOk(): void
    {
        $surveyId = '00000000-0000-0000-0000-000000000001';

        /**
         * @var \Cake\Datasource\EntityInterface
         */
        $survey = $this->Surveys->getSurveyData($surveyId);

        $query = $this->SurveyQuestions->find()
            ->where(['survey_id' => $survey->get('id')]);
        /**
         * @var \Cake\Datasource\EntityInterface
         */
        $question = $query->first();

        $query = $this->SurveyAnswers->find()
            ->where(['survey_question_id' => $question->get('id')]);
        /**
         * @var \Cake\Datasource\EntityInterface
         */
        $answer = $query->first();

        $url = '/surveys/survey/' . $survey->get('slug') . '/answers/edit/' . $question->get('id') . '/' . $answer->get('id');

        $editData = [
            'answer' => 'Doctor Who?',
        ];

        $this->post($url, $editData);

        $this->assertRedirect(['controller' => 'SurveyQuestions', 'action' => 'view', $survey->get('slug'), $question->get('id')]);

        $query = $this->SurveyAnswers->find()
            ->where(['id' => $answer->get('id')]);
        /**
         * @var \Cake\Datasource\EntityInterface
         */
        $edited = $query->first();

        $this->assertEquals($edited->get('answer'), $editData['answer']);
        $this->assertEquals($edited->get('id'), $answer->get('id'));
    }
}
