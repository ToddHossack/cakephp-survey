<?php
namespace Qobo\Survey\Test\TestCase\Controller;

use Cake\Datasource\EntityInterface;
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
        'plugin.qobo/survey.survey_sections',
        'plugin.qobo/survey.surveys',
        'plugin.qobo/survey.users',
    ];

    /**
     * @var \Qobo\Survey\Model\Table\SurveysTable $Surveys
     */
    public $Surveys;

    /**
     * @var \Qobo\Survey\Model\Table\SurveyQuestionsTable $SurveyQuestions
     */
    public $SurveyQuestions;

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
        $table = TableRegistry::get('Survey.Surveys', ['className' => SurveysTable::class]);
        $this->Surveys = $table;

        /**
         * @var \Qobo\Survey\Model\Table\SurveyQuestionsTable $table
         */
        $table = TableRegistry::get('Survey.SurveyQuestions', ['className' => SurveyQuestionsTable::class]);
        $this->SurveyQuestions = $table;
    }

    public function testViewOk(): void
    {
        $surveyId = '00000000-0000-0000-0000-000000000001';
        $survey = $this->Surveys->getSurveyData($surveyId);
        if (! $survey instanceof EntityInterface) {
            $this->fail("Survey is not of EntityInterface type: " . __METHOD__);

            return;
        }

        $slug = $survey->get('slug');

        $query = $this->SurveyQuestions->find()
            ->where(['survey_id' => $survey->get('id')]);

        $question = $query->first();

        if (! $question instanceof EntityInterface) {
            $this->fail("Question query result is not of EntityInterface type: " . __METHOD__);

            return;
        }

        $this->get('/surveys/survey/' . $survey->get('slug') . '/questions/view/' . $question->get('id'));
        $this->assertResponseOk();
    }

    public function testPreviewOk(): void
    {
        $surveyId = '00000000-0000-0000-0000-000000000001';
        $survey = $this->Surveys->getSurveyData($surveyId);

        if (! $survey instanceof EntityInterface) {
            $this->fail("Survey is not of EntityInterface type: " . __METHOD__);

            return;
        }

        $slug = $survey->get('slug');

        $query = $this->SurveyQuestions->find()
            ->where(['survey_id' => $survey->get('id')]);

        $question = $query->first();

        if (! $question instanceof EntityInterface) {
            $this->fail("Question is not of EntityInterface type: " . __METHOD__);

            return;
        }

        $url = '/surveys/survey/' . $survey->get('slug') . '/questions/preview/' . $question->get('id');

        $this->get($url);
        $this->assertResponseOk();

        $this->post($url);
        $this->assertResponseOk();
    }

    public function testAddOk(): void
    {
        $surveyId = '00000000-0000-0000-0000-000000000001';
        $survey = $this->Surveys->getSurveyData($surveyId);

        if (! $survey instanceof EntityInterface) {
            $this->fail("Survey is not of EntityInterface type: " . __METHOD__);

            return;
        }

        $slug = $survey->get('slug');
        $url = '/surveys/survey/' . $slug . '/questions/add';

        $this->get($url);
        $this->assertResponseOk();
    }

    public function testEditOk(): void
    {
        $surveyId = '00000000-0000-0000-0000-000000000001';
        $survey = $this->Surveys->getSurveyData($surveyId);

        if (! $survey instanceof EntityInterface) {
            $this->fail("EntityInterface is not of EntityInterface type: " . __METHOD__);

            return;
        }

        $slug = $survey->get('slug');

        $query = $this->SurveyQuestions->find()
            ->where(['survey_id' => $survey->get('id')]);

        $question = $query->first();

        if (! $question instanceof EntityInterface) {
            $this->fail("Question is not of EntityInterface type: " . __METHOD__);

            return;
        }

        $url = '/surveys/survey/' . $slug . '/questions/edit/' . $question->get('id');

        $this->get($url);
        $this->assertResponseOk();
    }

    public function testDeleteOk(): void
    {
        $surveyId = '00000000-0000-0000-0000-000000000001';
        $survey = $this->Surveys->getSurveyData($surveyId);

        if (! $survey instanceof EntityInterface) {
            $this->fail("Survey is not of EntityInterface type: " . __METHOD__);

            return;
        }

        $slug = $survey->get('slug');

        $query = $this->SurveyQuestions->find()
            ->where(['survey_id' => $survey->get('id')]);

        $question = $query->first();

        if (! $question instanceof EntityInterface) {
            $this->fail("Question is not of EntityInterface type: " . __METHOD__);

            return;
        }

        $url = '/surveys/survey/' . $slug . '/questions/delete/' . $question->get('id');
        $this->delete($url);
        $this->assertRedirect(['controller' => 'Surveys', 'action' => 'view', $slug]);
    }

    /**
     * \Cake\Datasource\Exception\RecordNotFoundException
     */
    public function testDeleteFailed(): void
    {
        $surveyId = '00000000-0000-0000-0000-000000000001';
        $survey = $this->Surveys->getSurveyData($surveyId);

        if (! $survey instanceof EntityInterface) {
            $this->fail("Survey is not of EntityInterface type: " . __METHOD__);

            return;
        }

        $slug = $survey->get('slug');

        $query = $this->SurveyQuestions->find()
            ->where(['survey_id' => $survey->get('id')]);

        $question = $query->first();

        if (! $question instanceof EntityInterface) {
            $this->fail("Question is not of EntityInterface type: " . __METHOD__);

            return;
        }

        $url = '/surveys/survey/' . $slug . '/questions/delete/' . $question->get('id');

        $fakeUrl = $url . '-fake';
        $this->delete($fakeUrl);
        $this->assertResponseCode(404);
    }

    public function testAddPostOk(): void
    {
        $surveyId = '00000000-0000-0000-0000-000000000001';
        $survey = $this->Surveys->getSurveyData($surveyId);

        if (! $survey instanceof EntityInterface) {
            $this->fail("Survey is not of EntityInterface type: " . __METHOD__);

            return;
        }
        $slug = $survey->get('slug');

        $postData = [
            'survey_id' => $survey->get('id'),
            'survey_section_id' => $surveyId,
            'question' => 'Who are you?',
            'type' => 'checkbox',
            'order' => 1
        ];

        $this->post('/surveys/survey/' . $slug . '/questions/add', $postData);
        $query = $this->SurveyQuestions->find()
            ->where(['question' => $postData['question']]);

        $question = $query->first();

        if (! $question instanceof EntityInterface) {
            $this->fail("Question is not of type EntityInterface type: " . __METHOD__);

            return;
        }

        $this->assertRedirect(['controller' => 'SurveyAnswers', 'action' => 'add', $survey->get('slug'), $question->get('id')]);
        $this->assertEquals($question->get('question'), $postData['question']);
        $this->assertEquals($question->get('type'), $postData['type']);
    }

    public function testEditPostOk(): void
    {
        $surveyId = '00000000-0000-0000-0000-000000000001';
        $questionId = '00000000-0000-0000-0000-000000000001';
        $survey = $this->Surveys->getSurveyData($surveyId);

        if (! $survey instanceof EntityInterface) {
            $this->fail("Survey is not of EntityInterface type: " . __METHOD__);

            return;
        }
        $slug = $survey->get('slug');

        $editData = [
            'question' => 'Who are they?',
        ];

        $this->post('/surveys/survey/' . $slug . '/questions/edit/' . $questionId, $editData);

        $query = $this->SurveyQuestions->find()
            ->where(['id' => $questionId]);

        /**
         * @var \Qobo\Survey\Model\Entity\SurveyQuestion $editedQuestion
         */
        $editedQuestion = $query->first();

        $this->assertRedirect(['controller' => 'SurveyQuestions', 'action' => 'view', $slug, $editedQuestion->get('id')]);
        $this->assertEquals($editedQuestion->question, $editData['question']);
        $this->assertEquals($editedQuestion->id, $questionId);
    }

    public function testMoveQuestionDown(): void
    {
        $id = '00000000-0000-0000-0000-000000000005';
        $question = $this->SurveyQuestions->get($id);

        $this->post('/surveys/survey/' . $question->get('id') . '/questions/move/down');

        $modified = $this->SurveyQuestions->get($id);

        $this->assertEquals(($question->get('order') + 1), $modified->get('order'));
    }

    public function testMoveQuestionUp(): void
    {
        $id = '00000000-0000-0000-0000-000000000006';
        $question = $this->SurveyQuestions->get($id);

        $this->post('/surveys/survey/' . $question->get('id') . '/questions/move/up');

        $modified = $this->SurveyQuestions->get($id);

        $this->assertEquals(($question->get('order') - 1), $modified->get('order'));
    }
}
