<?php
namespace Qobo\Survey\Test\TestCase\Model\Table;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Qobo\Survey\Model\Table\SurveyEntriesTable;

/**
 * Qobo\Survey\Model\Table\SurveyEntriesTable Test Case
 */
class SurveyEntriesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Qobo\Survey\Model\Table\SurveyEntriesTable
     */
    public $SurveyEntries;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.qobo/survey.survey_results',
        'plugin.qobo/survey.survey_entries',
        'plugin.qobo/survey.surveys',
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
    public function testGetStatuses() : void
    {
        $this->assertTrue(is_array(Configure::read('Survey.Options.statuses')));
        $this->assertEquals(Configure::read('Survey.Options.statuses'), $this->SurveyEntries->getStatuses());
    }

    public function testGetTotalScoreFromEntity() : void
    {
        $entryId = '00000000-0000-0000-0000-000000000003';
        $entity = $this->SurveyEntries->get($entryId);

        $score = $entity->getTotalScore();
        $this->assertEquals(10, $score);
    }
}
