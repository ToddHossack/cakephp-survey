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
        'reference_id' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'survey_question_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'answer' => ['type' => 'text', 'length' => 4294967295, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'comment' => ['type' => 'text', 'length' => 4294967295, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'score' => ['type' => 'decimal', 'length' => 10, 'precision' => 0, 'unsigned' => false, 'null' => true, 'default' => '0', 'comment' => ''],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'trashed' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'order' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
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
            'order' => 1,
            'trashed' => null,
        ],
        [
            'id' => '00000000-0000-0000-0000-000000000002',
            'survey_question_id' => '00000000-0000-0000-0000-000000000001',
            'answer' => 'Not To Be',
            'comment' => 'Some comment',
            'created' => '2018-03-14 10:59:30',
            'modified' => '2018-03-14 10:59:30',
            'order' => 2,
            'trashed' => null,
        ],
        [
            'id' => '00000000-0000-0000-0000-000000000003',
            'survey_question_id' => '00000000-0000-0000-0000-000000000002',
            'answer' => 'Yes',
            'comment' => 'Some comment',
            'created' => '2018-03-14 10:59:30',
            'modified' => '2018-03-14 10:59:30',
            'order' => 2,
            'trashed' => null,
        ],
        [
            'id' => '00000000-0000-0000-0000-000000000004',
            'survey_question_id' => '00000000-0000-0000-0000-000000000002',
            'answer' => 'No',
            'comment' => 'Some comment',
            'created' => '2018-03-14 10:59:30',
            'modified' => '2018-03-14 10:59:30',
            'order' => 23,
            'trashed' => null,
        ],
        [
            'id' => '00000000-0000-0000-0000-000000000005',
            'survey_question_id' => '00000000-0000-0000-0000-000000000003',
            'answer' => '',
            'comment' => 'Put your YYYY-MM-DD date',
            'created' => '2018-03-14 10:59:30',
            'modified' => '2018-03-14 10:59:30',
            'order' => 43,
            'trashed' => null,
        ],
        [
            'id' => '00000000-0000-0000-0000-000000000006',
            'survey_question_id' => '00000000-0000-0000-0000-000000000004',
            'answer' => '',
            'comment' => 'Put your YYYY-MM-DD date',
            'created' => '2018-03-14 10:59:30',
            'modified' => '2018-03-14 10:59:30',
            'score' => 13,
            'order' => 43,
            'trashed' => null,
        ],
        [
            'id' => '00000000-0000-0000-0000-000000000007',
            'survey_question_id' => '00000000-0000-0000-0000-000000000007',
            'answer' => 'London',
            'comment' => '',
            'created' => '2018-08-29 10:56:36',
            'modified' => '2018-08-29 10:56:36',
            'order' => 1,
            'score' => 1,
            'trashed' => null,
        ],
        [
            'id' => '00000000-0000-0000-0000-000000000008',
            'survey_question_id' => '00000000-0000-0000-0000-000000000007',
            'answer' => 'Tokyo',
            'comment' => '',
            'created' => '2018-08-29 10:56:36',
            'modified' => '2018-08-29 10:56:36',
            'order' => 2,
            'score' => 2,
            'trashed' => null,
        ],
        [
            'id' => '00000000-0000-0000-0000-000000000009',
            'survey_question_id' => '00000000-0000-0000-0000-000000000007',
            'answer' => 'Paris',
            'comment' => '',
            'created' => '2018-08-29 10:56:36',
            'modified' => '2018-08-29 10:56:36',
            'order' => 3,
            'score' => 5,
            'trashed' => null,
        ],
        [
            'id' => '00000000-0000-0000-0000-000000000010',
            'survey_question_id' => '00000000-0000-0000-0000-000000000007',
            'answer' => 'Moscow',
            'comment' => '',
            'created' => '2018-08-29 10:56:36',
            'modified' => '2018-08-29 10:56:36',
            'order' => 4,
            'score' => 10,
            'trashed' => null,
        ],
    ];
}
