<?php
namespace Qobo\Survey\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SurveyEntriesFixture
 *
 */
class SurveyEntriesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'survey_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'resource_id' => ['type' => 'uuid', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'resource' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'status' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'score' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'context' => ['type' => 'text', 'length' => 4294967295, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'comment' => ['type' => 'text', 'length' => 4294967295, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'submit_date' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'trashed' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'survey_id' => ['type' => 'index', 'columns' => ['survey_id'], 'length' => []],
            'status' => ['type' => 'index', 'columns' => ['status'], 'length' => []],
        ],
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
                'survey_id' => '00000000-0000-0000-0000-000000000004',
                'resource_id' => '00000000-0000-0000-0000-000000000001',
                'resource' => 'Users',
                'status' => 'passed',
                'score' => 58,
                'context' => 'JSON encoded context',
                'comment' => 'Received survey comment',
                'submit_date' => '2019-08-29 09:00:00',
                'created' => '2019-08-29 14:23:17',
                'modified' => '2019-08-29 14:23:17',
                'trashed' => null,
            ],
            [
                'id' => '00000000-0000-0000-0000-000000000002',
                'survey_id' => '00000000-0000-0000-0000-000000000004',
                'resource_id' => '00000000-0000-0000-0000-000000000002',
                'resource' => 'Users',
                'status' => 'failed',
                'score' => 0,
                'context' => 'JSON encoded context',
                'comment' => 'Received survey comment',
                'submit_date' => '2019-08-29 09:30:00',
                'created' => '2019-08-29 14:23:17',
                'modified' => '2019-08-29 14:23:17',
                'trashed' => null,
            ],
            [
                'id' => '00000000-0000-0000-0000-000000000003',
                'survey_id' => '00000000-0000-0000-0000-000000000004',
                'resource_id' => '00000000-0000-0000-0000-000000000001',
                'resource' => 'Users',
                'status' => 'received',
                'score' => 0,
                'context' => 'JSON encoded context',
                'comment' => 'Received survey comment',
                'submit_date' => '2019-08-29 07:00:00',
                'created' => '2019-08-29 14:23:17',
                'modified' => '2019-08-29 14:23:17',
                'trashed' => null,
            ],
        ];
        parent::init();
    }
}
