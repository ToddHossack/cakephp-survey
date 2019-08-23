<?php
namespace Qobo\Survey\Test\TestCase\Model\Table;

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
        $config = TableRegistry::getTableLocator()->exists('SurveyEntries') ? [] : ['className' => SurveyEntriesTable::class];
        /** @var \Qobo\Survey\Model\Table\SurveyEntriesTable $table */
        $table = TableRegistry::getTableLocator()->get('SurveyEntries', $config);
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
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize() : void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault() : void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules() : void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
