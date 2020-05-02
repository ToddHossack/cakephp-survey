<?php
namespace Qobo\Survey\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Qobo\Survey\Model\Table\SurveyQuestionsTable;

/**
 * Qobo\Survey\Model\Table\SurveyQuestionsTable Test Case
 */
class SurveyQuestionsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Qobo\Survey\Model\Table\SurveyQuestionsTable
     */
    public $SurveyQuestions;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.Qobo/Survey.SurveyQuestions',
        'plugin.Qobo/Survey.Surveys',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Survey.SurveyQuestions') ? [] : ['className' => SurveyQuestionsTable::class];
        /**
         * @var \Qobo\Survey\Model\Table\SurveyQuestionsTable $table
         */
        $table = TableRegistry::getTableLocator()->get('Survey.SurveyQuestions', $config);
        $this->SurveyQuestions = $table;
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SurveyQuestions);

        parent::tearDown();
    }

    public function testGetQuestionTypes(): void
    {
        $result = $this->SurveyQuestions->getQuestionTypes();
        $this->assertTrue(is_array($result));
        $this->assertNotEmpty($result);
    }
}
