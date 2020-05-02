<?php
namespace Qobo\Survey\Test\TestCase\Model\Table;

use Cake\Core\Configure;
use Cake\Datasource\EntityInterface;
use Cake\Event\EventList;
use Cake\Event\EventManager;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Qobo\Survey\Event\EventName;
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
        'plugin.Qobo/Survey.Surveys',
        'plugin.Qobo/Survey.SurveyQuestions',
        'plugin.Qobo/Survey.SurveyAnswers',
        'plugin.Qobo/Survey.SurveySections',
        'plugin.Qobo/Survey.SurveyResults',
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

        /**
         * @var \Qobo\Survey\Model\Table\SurveysTable $table
         */
        $table = TableRegistry::getTableLocator()->get('Surveys', $config);
        $this->Surveys = $table;
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
        $this->assertEquals($result['default'], 'Default');
    }

    public function testGetSurveyData(): void
    {
        $surveyId = '00000000-0000-0000-0000-000000000001';
        $result = $this->Surveys->getSurveyData(null);

        $this->assertEmpty($result);
        /**
         * @var \Cake\Datasource\EntityInterface
         */
        $result = $this->Surveys->getSurveyData($surveyId);
        $this->assertInstanceOf(EntityInterface::class, $result);
        $this->assertEquals($result->get('id'), $surveyId);

        /**
         * @var \Cake\Datasource\EntityInterface
         */
        $result = $this->Surveys->getSurveyData($surveyId, true);
        $this->assertInstanceOf(EntityInterface::class, $result);
        $this->assertTrue((count($result->get('survey_sections')) > 0));

        $result = $this->Surveys->getSurveyData('foobar_slug');
        $this->assertEmpty($result);

        /**
         * @var \Cake\Datasource\EntityInterface
         */
        $result = $this->Surveys->getSurveyData('survey_-_1');
        $this->assertInstanceOf(EntityInterface::class, $result);
        $this->assertEquals($result->get('id'), $surveyId);
    }

    public function testSetSequentialOrder(): void
    {
        $id = '00000000-0000-0000-0000-000000000002';
        /**
         * @var \Cake\Datasource\EntityInterface
         */
        $survey = $this->Surveys->getSurveyData($id, true);
        $sorted = $this->Surveys->setSequentialOrder($survey);

        /**
         * @var \Cake\Datasource\EntityInterface
         */
        $modified = $this->Surveys->getSurveyData($id, true);
        $this->assertInstanceOf(EntityInterface::class, $modified);

        $oldQuestionOrders = array_map(
            function ($item) {
                return $item->get('order');
            },
            $survey->get('survey_sections')[0]->get('survey_questions')
        );

        $newQuestionOrders = array_map(
            function ($item) {
                return $item->order;
            },
            $modified->get('survey_sections')[0]->get('survey_questions')
        );

        $this->assertNotEquals($oldQuestionOrders, $newQuestionOrders);

        foreach ($survey->get('survey_sections') as $section) {
            foreach ($section->get('survey_questions') as $k => $question) {
                $oldAnswerOrder = array_map(
                    function ($item) {
                        return $item->get('order');
                    },
                    $question->get('survey_answers')
                );

                $newAnwserOrder = array_map(
                    function ($item) {
                        return $item->get('order');
                    },
                    $modified->get('survey_sections')[0]->get('survey_questions')[$k]->get('survey_answers')
                );

                $this->assertNotEquals($oldAnswerOrder, $newAnwserOrder);
            }
        }
    }

    /**
     * Test whether the publish event is called after an entity
     */
    public function testPublishEventIsCalled(): void
    {
        $eventManager = EventManager::instance();
        $eventManager->setEventList(new EventList());

        $surveyId = '00000000-0000-0000-0000-000000000001';
        $entity = $this->Surveys->get($surveyId);
        $entity->set('publish_date', Time::now());
        $entity->set('expiry_date', new Time('next year'));
        $result = $this->Surveys->save($entity, ['publishSurvey' => true]);
        $this->assertEventFired((string)EventName::PUBLISH_SURVEY());
    }
}
