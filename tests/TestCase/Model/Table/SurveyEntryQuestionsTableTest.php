<?php
namespace Qobo\Survey\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Qobo\Survey\Model\Table\SurveyEntryQuestionsTable;

/**
 * Qobo\Survey\Model\Table\SurveyEntryQuestionsTable Test Case
 */
class SurveyEntryQuestionsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Qobo\Survey\Model\Table\SurveyEntryQuestionsTable
     */
    public $SurveyEntryQuestions;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.qobo/survey.survey_entry_questions',
        'plugin.qobo/survey.survey_entries',
        'plugin.qobo/survey.survey_questions'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('SurveyEntryQuestions') ? [] : ['className' => SurveyEntryQuestionsTable::class];
        /** @var \Qobo\Survey\Model\Table\SurveyEntryQuestionsTable $table */
        $table = TableRegistry::getTableLocator()->get('SurveyEntryQuestions', $config);
        $this->SurveyEntryQuestions = $table;
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SurveyEntryQuestions);

        parent::tearDown();
    }
}
