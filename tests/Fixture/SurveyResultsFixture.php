<?php
namespace Qobo\Survey\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SurveyResultsFixture
 *
 */
class SurveyResultsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'submit_id' => ['type' => 'uuid', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'survey_entry_question_id' => ['type' => 'uuid', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'submit_date' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'survey_id' => ['type' => 'uuid', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'survey_question_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'survey_answer_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'user_id' => ['type' => 'uuid', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'result' => ['type' => 'text', 'length' => 4294967295, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'trashed' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'score' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'comment' => ['type' => 'text', 'length' => 4294967295, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'status' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        '_indexes' => [],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8mb4_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'id' => '00000000-0000-0000-0000-000000000001',
                'submit_id' => '00000000-0000-0000-0000-000000000001',
                'submit_date' => '2018-04-09 09:00:00',
                'survey_id' => '00000000-0000-0000-0000-000000000001',
                'survey_question_id' => '00000000-0000-0000-0000-000000000001',
                'survey_answer_id' => '00000000-0000-0000-0000-000000000001',
                'user_id' => '00000000-0000-0000-0000-000000000001',
                'result' => 'Lorem ipsum dolor sit amet, aliquet feugiat.',
                'created' => '2019-08-29 14:57:08',
                'modified' => '2019-08-29 14:57:08',
                'score' => 1,
                'comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat.',
                'status' => 'pass',
                'trashed' => null,
                'survey_entry_question_id' => null,
            ],
            [
                'id' => '00000000-0000-0000-0000-000000000002',
                'submit_id' => '00000000-0000-0000-0000-000000000004',
                'submit_date' => '2018-04-09 09:00:00',
                'survey_id' => '00000000-0000-0000-0000-000000000001',
                'survey_question_id' => '00000000-0000-0000-0000-000000000007',
                'survey_answer_id' => '00000000-0000-0000-0000-000000000007',
                'user_id' => null,
                'result' => null,
                'created' => '2019-08-29 14:57:08',
                'modified' => '2019-08-29 14:57:08',
                'score' => 1,
                'comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat.',
                'status' => 'pass',
                'trashed' => null,
                'survey_entry_question_id' => null,
            ],
            [
                'id' => '00000000-0000-0000-0000-000000000003',
                'submit_id' => '00000000-0000-0000-0000-000000000003',
                'submit_date' => '2018-04-09 09:00:00',
                'survey_id' => '00000000-0000-0000-0000-000000000004',
                'survey_question_id' => '00000000-0000-0000-0000-000000000007',
                'survey_answer_id' => '00000000-0000-0000-0000-000000000010',
                'user_id' => null,
                'result' => null,
                'created' => '2019-08-29 14:57:08',
                'modified' => '2019-08-29 14:57:08',
                'score' => 10,
                'comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat.',
                'status' => 'pass',
                'trashed' => null,
                'survey_entry_question_id' => '00000000-0000-0000-0000-000000000001',
            ],
            [
                'id' => '00000000-0000-0000-0000-000000000004',
                'submit_id' => '00000000-0000-0000-0000-000000000003',
                'submit_date' => '2018-04-09 09:00:00',
                'survey_id' => '00000000-0000-0000-0000-000000000004',
                'survey_question_id' => '00000000-0000-0000-0000-000000000008',
                'survey_answer_id' => '00000000-0000-0000-0000-000000000011',
                'user_id' => null,
                'result' => 'Hello World',
                'created' => '2019-08-29 14:57:08',
                'modified' => '2019-08-29 14:57:08',
                'score' => 10,
                'comment' => 'no comments',
                'status' => 'pass',
                'trashed' => null,
                'survey_entry_question_id' => null,
            ],
            [
                'id' => '00000000-0000-0000-0000-000000000005',
                'submit_id' => null,
                'submit_date' => '2018-04-09 09:00:00',
                'survey_id' => '00000000-0000-0000-0000-000000000004',
                'survey_question_id' => '00000000-0000-0000-0000-000000000008',
                'survey_answer_id' => '00000000-0000-0000-0000-000000000011',
                'user_id' => null,
                'result' => 'Hello World',
                'created' => '2019-08-29 14:57:08',
                'modified' => '2019-08-29 14:57:08',
                'score' => 10,
                'comment' => 'no comments',
                'status' => 'pass',
                'trashed' => null,
                'survey_entry_question_id' => '00000000-0000-0000-0000-000000000002',
            ],
        ];

        parent::init();
    }
}
