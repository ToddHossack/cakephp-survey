<?php
namespace Qobo\Survey\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SurveyAnswersFixture
 *
 */
class SurveyAnswersFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'survey_question_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'answer' => ['type' => 'text', 'length' => 4294967295, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'comment' => ['type' => 'text', 'length' => 4294967295, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'trashed' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'survey_question_id' => ['type' => 'index', 'columns' => ['survey_question_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => '00000000-0000-0000-0000-000000000001',
            'survey_question_id' => '00000000-0000-0000-0000-000000000001',
            'answer' => 'To Be',
            'comment' => 'Some comment',
            'created' => '2018-03-14 10:59:30',
            'modified' => '2018-03-14 10:59:30',
            'trashed' => null,
        ],
        [
            'id' => '00000000-0000-0000-0000-000000000002',
            'survey_question_id' => '00000000-0000-0000-0000-000000000001',
            'answer' => 'Not To Be',
            'comment' => 'Some comment',
            'created' => '2018-03-14 10:59:30',
            'modified' => '2018-03-14 10:59:30',
            'trashed' => null,
        ],
    ];
}
