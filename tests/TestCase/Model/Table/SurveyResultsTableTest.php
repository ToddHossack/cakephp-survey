<?php
namespace Qobo\Survey\Test\TestCase\Model\Table;

use Cake\Datasource\EntityInterface;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Qobo\Survey\Model\Table\SurveyResultsTable;
use Qobo\Survey\Model\Table\SurveysTable;

/**
 * Qobo\Survey\Model\Table\SurveyResultsTable Test Case
 */
class SurveyResultsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Qobo\Survey\Model\Table\SurveyResultsTable
     */
    public $SurveyResults;

    /**
     * @var \Qobo\Survey\Model\Table\SurveysTable
     */
    public $Surveys;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.qobo/survey.survey_results',
        'plugin.qobo/survey.surveys',
        'plugin.qobo/survey.survey_questions',
        'plugin.qobo/survey.survey_answers',
        'plugin.qobo/survey.survey_sections',
        'plugin.qobo/survey.users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Qobo\Survey.SurveyResults') ? [] : ['className' => SurveyResultsTable::class];
        /**
         * @var \Qobo\Survey\Model\Table\SurveyResultsTable $table
         */
        $table = TableRegistry::get('SurveyResults', $config);
        $this->SurveyResults = $table;

        /**
         * @var \Qobo\Survey\Model\Table\SurveysTable $table
         */
        $table = TableRegistry::get('Surveys', ['className' => SurveysTable::class]);
        $this->Surveys = $table;
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SurveyResults);

        parent::tearDown();
    }

    /**
     * @dataProvider getResultsProvider
     * @param mixed[] $data Data
     * @param int $expected Expected result
     */
    public function testGetResults(array $data, int $expected): void
    {
        $user = ['id' => '123'];
        $survey = (object)[
            'id' => '111',
        ];

        $result = $this->SurveyResults->getResults($data, [
            'user' => $user,
            'survey' => $survey
        ]);

        $this->assertEquals(count($result), $expected);
    }

    /**
     * @return mixed[]
     */
    public function getResultsProvider(): array
    {
        return [
            [
                [],
                0
            ],
            [
                [
                    'user_id' => '123',
                    'survey_question_id' => '123123',
                    'survey_answer_id' => '123',
                    'survey_id' => '321'
                ],
                1
            ],
            [
                 [
                    'user_id' => '123',
                    'survey_question_id' => '123123',
                    'survey_answer_id' => ['123', '456'],
                    'survey_id' => '321'
                 ],
                 2
            ]
        ];
    }

    public function testSaveDataErrors(): void
    {
        /**
         * @var \Cake\Datasource\EntityInterface
         */
        $survey = $this->Surveys->getSurveyData('survey_-_1', true);
        $data = [
            'user_id' => '00000000-0000-0000-0000-000000000001',
            'survey_id' => $survey->id,
            'survey_answer_id' => null,
            'survey_question_id' => $survey->get('survey_sections')[0]->get('survey_questions')[0]->get('id'),
            'result' => 'w00t',
        ];

        $result = $this->SurveyResults->saveData($data);
        $this->assertEquals($result['status'], false);
        $this->assertNotEmpty($result['entity']->getErrors());
    }
}
