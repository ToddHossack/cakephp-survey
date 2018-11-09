<?php
namespace Qobo\Survey\Test\TestCase\Model\Table;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Qobo\Survey\Model\Table\SurveysTable;

/**
 * Qobo\Survey\Model\Table\SurveysTable Test Case
 */
class SurveysTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Qobo\Survey\Model\Table\SurveysTable
     */
    public $Surveys;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.qobo/survey.surveys',
        'plugin.qobo/survey.survey_questions',
        'plugin.qobo/survey.survey_answers',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Surveys') ? [] : ['className' => SurveysTable::class];
        $this->Surveys = TableRegistry::get('Surveys', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Surveys);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    public function testGetSurveyCategories(): void
    {
        $result = $this->Surveys->getSurveyCategories();
        $this->assertTrue(is_array($result));
        $this->assertEquals($result['test_default'], 'Test Default');
    }

    public function testGetSurveyData(): void
    {
        $surveyId = '00000000-0000-0000-0000-000000000001';
        $result = $this->Surveys->getSurveyData(null);
        $this->assertEmpty($result);

        $result = $this->Surveys->getSurveyData($surveyId);
        $this->assertEquals($result->id, $surveyId);

        $result = $this->Surveys->getSurveyData($surveyId, true);
        $this->assertTrue((count($result->survey_questions) > 0));

        $result = $this->Surveys->getSurveyData('foobar_slug');
        $this->assertEmpty($result);

        $result = $this->Surveys->getSurveyData('survey_-_1');
        $this->assertEquals($result->id, $surveyId);
    }

    public function testSetSequentialOrder(): void
    {
        $id = '00000000-0000-0000-0000-000000000002';
        $survey = $this->Surveys->getSurveyData($id, true);
        $sorted = $this->Surveys->setSequentialOrder($survey);

        $modified = $this->Surveys->getSurveyData($id, true);

        $oldQuestionOrders = array_map(
            function ($item) {
                return $item->order;
            },
            $survey->survey_questions
        );

        $newQuestionOrders = array_map(
            function ($item) {
                return $item->order;
            },
            $modified->survey_questions
        );

        $this->assertNotEquals($oldQuestionOrders, $newQuestionOrders);

        foreach ($survey->survey_questions as $k => $question) {
            $oldAnswerOrder = array_map(
                function ($item) {
                    return $item->order;
                },
                $question->survey_answers
            );

            $newAnwserOrder = array_map(
                function ($item) {
                    return $item->order;
                },
                $modified->survey_questions[$k]->survey_answers
            );

            $this->assertNotEquals($oldAnswerOrder, $newAnwserOrder);
        }
    }
}
