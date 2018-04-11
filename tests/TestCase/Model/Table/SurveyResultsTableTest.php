<?php
namespace Qobo\Survey\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Qobo\Survey\Model\Table\SurveyResultsTable;

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
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.qobo/survey.survey_results',
        'plugin.qobo/survey.surveys',
        'plugin.qobo/survey.survey_questions',
        'plugin.qobo/survey.survey_answers',
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
        $config = TableRegistry::exists('SurveyResults') ? [] : ['className' => SurveyResultsTable::class];
        $this->SurveyResults = TableRegistry::get('SurveyResults', $config);
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
     * @dataProvider testGetResultsProvider
     */
    public function testGetResults($data, $expected)
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

    public function testGetResultsProvider()
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
}
