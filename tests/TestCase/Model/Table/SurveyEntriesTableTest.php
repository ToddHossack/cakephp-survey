<?php
namespace Qobo\Survey\Test\TestCase\Model\Table;

use Cake\Core\Configure;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Qobo\Survey\Model\Table\SurveyEntriesTable;

/**
 * Qobo\Survey\Model\Table\SurveyEntriesTable Test Case
 */
class SurveyEntriesTableTest extends TestCase
{
    /** @var \Qobo\Survey\Model\Table\SurveyEntriesTable $SurveyEntries */
    protected $SurveyEntries;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.Qobo/Survey.SurveyAnswers',
        'plugin.Qobo/Survey.SurveyResults',
        'plugin.Qobo/Survey.SurveyEntries',
        'plugin.Qobo/Survey.SurveyQuestions',
        'plugin.Qobo/Survey.SurveyEntryQuestions',
        'plugin.Qobo/Survey.Surveys',
        'plugin.Qobo/Survey.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        /** @var \Qobo\Survey\Model\Table\SurveyEntriesTable $table */
        $table = TableRegistry::getTableLocator()->get('Qobo/Survey.SurveyEntries', ['className' => SurveyEntriesTable::class]);
        $this->SurveyEntries = $table;
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SurveyEntries);

        parent::tearDown();
    }

    /**
     * Make sure that Survey has status values
     *
     * @return void
     */
    public function testGetStatuses(): void
    {
        $this->assertTrue(is_array(Configure::read('Survey.Options.statuses')));
        $this->assertEquals(Configure::read('Survey.Options.statuses'), $this->SurveyEntries->getStatuses());
    }

    public function testGetTotalScoreFromEntity(): void
    {
        $entryId = '00000000-0000-0000-0000-000000000003';
        $entity = $this->SurveyEntries->get($entryId);

        $score = $entity->getTotalScore();
        $this->assertEquals(0, $score);
    }

    public function testGetSurveyEntryPayload(): void
    {
        $surveyEntryId = '00000000-0000-0000-0000-000000000003';
        $result = $this->SurveyEntries->getSurveyEntryPayload($surveyEntryId);

        $this->assertTrue(is_array($result));
        $this->assertTrue(!empty($result));

        $this->assertArrayHasKey('Surveys', $result);
        $this->assertArrayHasKey('SurveyEntries', $result);
        $this->assertArrayHasKey('SurveyEntryQuestions', $result);
    }

    /**
     * @dataProvider getSurveyResultsProvider
     *
     * @param mixed[] $data with survey_results samples
     * @return void
     */
    public function testSaveSurveyEntryData(array $data): void
    {
        $surveyId = '00000000-0000-0000-0000-000000000004';

        //creating fake EntityInterface for resource parameter
        $resourceEntity = new Entity(
            [
                'id' => '00000000-0000-0000-0000-000000000001',
                'first_name' => 'John',
                'last_name' => 'Doe',
            ],
            [
                'source' => 'Users',
            ]
        );

        /** @var \Qobo\Survey\Model\Entity\SurveyEntry $result */
        $result = $this->SurveyEntries->saveSurveyEntryData($data, $resourceEntity, $surveyId);

        $this->assertInstanceOf(\Qobo\Survey\Model\Entity\SurveyEntry::class, $result);
        $this->assertEquals($resourceEntity->get('id'), $result->get('resource_id'));
        $this->assertEquals($result->get('survey_id'), $surveyId);
    }

    /**
     * @return mixed[]
     */
    public function getSurveyResultsProvider(): array
    {
        return [
            [
                // test case with singular answers
                [
                    [
                        'survey_question_id' => '00000000-0000-0000-0000-000000000007',
                        'survey_answer_id' => '00000000-0000-0000-0000-000000000010',
                    ],
                    [
                        'survey_question_id' => '00000000-0000-0000-0000-000000000008',
                        'survey_answer_id' => '00000000-0000-0000-0000-000000000011',
                    ],
                ],
            ],
            [
                // example of survey_results containing array of answer ids picked.
                [
                    [
                        'survey_question_id' => '00000000-0000-0000-0000-000000000007',
                        'survey_answer_id' => [
                            '00000000-0000-0000-0000-000000000010',
                            '00000000-0000-0000-0000-000000000009',
                        ],
                    ],
                    [
                        'survey_question_id' => '00000000-0000-0000-0000-000000000008',
                        'survey_answer_id' => '00000000-0000-0000-0000-000000000011',
                    ],
                ],
            ],
        ];
    }
}
